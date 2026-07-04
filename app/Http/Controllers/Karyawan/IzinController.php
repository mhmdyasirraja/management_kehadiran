<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Karyawan;

class IzinController extends Controller
{
    private const MIN_HARI_CUTI = 7;
    private const MAX_HARI_LAPOR_SAKIT = 3;
    private const MAX_HARI_CUTI_PER_TAHUN = 12;

    private function authUser()
    {
        return Auth::guard('karyawan')->user();
    }

    private function authKaryawan(): Karyawan
    {
        /** @var \App\Models\User $user */
        $user = $this->authUser();
        return Karyawan::where('user_id', $user->id)->firstOrFail();
    }

    public function index()
    {
        $karyawan = $this->authKaryawan();

        $izin = Izin::where('karyawan_id', $karyawan->id)
            ->latest()
            ->get();

        $total    = $izin->count();
        $pending  = $izin->where('status', 'pending')->count();
        $selesai  = $izin->whereIn('status', ['approved', 'rejected'])->count();
        $sisaCuti = $this->sisaCuti($karyawan, now()->year);

        return view('pages.karyawan.pengajuan', compact('izin', 'total', 'pending', 'selesai', 'sisaCuti'))
            ->with('kuotaCuti', self::MAX_HARI_CUTI_PER_TAHUN);
    }

    private function hitungCutiTerpakai(Karyawan $karyawan, int $tahun): int
    {
        return Izin::where('karyawan_id', $karyawan->id)
            ->where('jenis_izin', 'cuti')
            ->whereIn('status', ['pending', 'approved'])
            ->whereYear('tanggal_mulai', $tahun)
            ->get(['tanggal_mulai', 'tanggal_selesai'])
            ->sum(function ($izin) {
                return Carbon::parse($izin->tanggal_mulai)
                    ->diffInDays(Carbon::parse($izin->tanggal_selesai)) + 1;
            });
    }

    private function sisaCuti(Karyawan $karyawan, int $tahun): int
    {
        return max(0, self::MAX_HARI_CUTI_PER_TAHUN - $this->hitungCutiTerpakai($karyawan, $tahun));
    }

    private function cekOverlapTanggal(
        $validator,
        Karyawan $karyawan,
        Carbon $tanggalMulai,
        Carbon $tanggalSelesai
    ): void {
        $overlap = Izin::where('karyawan_id', $karyawan->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('tanggal_mulai', '<=', $tanggalSelesai)
            ->where('tanggal_selesai', '>=', $tanggalMulai)
            ->exists();

        if ($overlap) {
            $validator->errors()->add(
                'tanggal_mulai',
                'Kamu sudah punya pengajuan izin lain yang tanggalnya bentrok dengan periode ini.'
            );
        }
    }

    public function store(Request $request)
    {
        $karyawan = $this->authKaryawan();

        $validator = Validator::make($request->all(), [
            'jenis_izin'       => 'required|in:sakit,cuti',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'       => 'required|string|max:1000',
            'surat_keterangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'jenis_izin.required'       => 'Jenis izin wajib dipilih.',
            'jenis_izin.in'             => 'Jenis izin tidak valid.',
            'tanggal_mulai.required'    => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date'        => 'Format tanggal mulai tidak valid.',
            'tanggal_selesai.required'  => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date'      => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'keterangan.required'       => 'Keterangan wajib diisi.',
            'keterangan.max'            => 'Keterangan maksimal 1000 karakter.',
            'surat_keterangan.file'     => 'File yang diunggah tidak valid.',
            'surat_keterangan.mimes'    => 'Format file harus PDF, JPG, atau PNG.',
            'surat_keterangan.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $validator->after(function ($validator) use ($request, $karyawan) {
            $this->validateAturanTanggal($validator, $request, $karyawan);
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $path = null;
        if ($request->hasFile('surat_keterangan')) {
            $path = $request->file('surat_keterangan')->store('surat_keterangan', 'public');
        }

        Izin::create([
            'karyawan_id'      => $karyawan->id,
            'jenis_izin'       => $data['jenis_izin'],
            'tanggal_mulai'    => $data['tanggal_mulai'],
            'tanggal_selesai'  => $data['tanggal_selesai'],
            'keterangan'       => $data['keterangan'],
            'surat_keterangan' => $path,
            'status'           => 'pending',
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    private function validateAturanTanggal($validator, Request $request, Karyawan $karyawan): void
    {
        $jenisIzin         = $request->input('jenis_izin');
        $tanggalMulaiRaw   = $request->input('tanggal_mulai');
        $tanggalSelesaiRaw = $request->input('tanggal_selesai');

        if (!$tanggalMulaiRaw) {
            return;
        }

        $tanggalMulai = Carbon::parse($tanggalMulaiRaw)->startOfDay();
        $hariIni      = Carbon::today();

        if ($jenisIzin === 'cuti') {
            $minimalTanggal = $hariIni->copy()->addDays(self::MIN_HARI_CUTI);

            if ($tanggalMulai->lt($minimalTanggal)) {
                $validator->errors()->add(
                    'tanggal_mulai',
                    'Pengajuan cuti harus diajukan minimal ' . self::MIN_HARI_CUTI . ' hari sebelum tanggal mulai.'
                );
            }

            if ($tanggalSelesaiRaw) {
                $tanggalSelesai = Carbon::parse($tanggalSelesaiRaw)->startOfDay();

                if ($tanggalMulai->year !== $tanggalSelesai->year) {
                    $validator->errors()->add(
                        'tanggal_selesai',
                        'Pengajuan cuti tidak boleh melewati pergantian tahun. Ajukan terpisah per tahun.'
                    );
                } else {
                    $durasiPengajuan = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
                    $sisa = $this->sisaCuti($karyawan, $tanggalMulai->year);

                    if ($durasiPengajuan > $sisa) {
                        $validator->errors()->add(
                            'tanggal_mulai',
                            "Sisa kuota cuti kamu tahun ini tinggal {$sisa} hari, pengajuan ini butuh {$durasiPengajuan} hari."
                        );
                    }
                }
            }
        }

        if ($jenisIzin === 'sakit') {
            $batasMaksimal = $hariIni->copy()->subDays(self::MAX_HARI_LAPOR_SAKIT);

            if ($tanggalMulai->lt($batasMaksimal)) {
                $validator->errors()->add(
                    'tanggal_mulai',
                    'Pengajuan sakit hanya bisa dilakukan maksimal ' . self::MAX_HARI_LAPOR_SAKIT . ' hari setelah tanggal sakit.'
                );
            }

            if ($tanggalMulai->gt($hariIni)) {
                $validator->errors()->add('tanggal_mulai', 'Tanggal sakit tidak boleh di masa depan.');
            }

            if ($tanggalSelesaiRaw) {
                $tanggalSelesai = Carbon::parse($tanggalSelesaiRaw)->startOfDay();
                $this->cekOverlapTanggal($validator, $karyawan, $tanggalMulai, $tanggalSelesai);
            }
        }
    }

    public function destroy(Izin $izin)
    {
        $karyawan = $this->authKaryawan();

        abort_if($izin->karyawan_id !== $karyawan->id, 403);
        abort_if($izin->status !== 'pending', 403, 'Hanya pengajuan pending yang bisa dibatalkan.');

        if ($izin->surat_keterangan) {
            Storage::disk('public')->delete($izin->surat_keterangan);
        }

        $izin->delete();

        return back()->with('success', 'Pengajuan izin berhasil dibatalkan.');
    }
}
