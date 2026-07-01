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
    // Aturan bisnis ditaro sebagai konstanta, biar gampang diubah
    // tanpa harus nyari-nyari angka "ajaib" di tengah logic
    private const MIN_HARI_CUTI = 7;
    private const MAX_HARI_LAPOR_SAKIT = 3;

    private function authUser()
    {
        return Auth::guard('karyawan')->user();
    }

    private function authKaryawan()
    {
        /** @var \App\Models\User $user */
        $user = $this->authUser();
        /** @var \App\Models\Karyawan $karyawan */
        $karyawan = Karyawan::where('user_id', $user->id)->firstOrFail();
        return $karyawan;
    }

    public function index()
    {
        $karyawan = $this->authKaryawan();

        $izin = Izin::where('karyawan_id', $karyawan->id)
            ->latest()
            ->get();

        $total   = $izin->count();
        $pending = $izin->where('status', 'pending')->count();
        $selesai = $izin->whereIn('status', ['approved', 'rejected'])->count();

        return view('pages.karyawan.pengajuan', compact('izin', 'total', 'pending', 'selesai'));
    }

    public function store(Request $request)
    {
        $karyawan = $this->authKaryawan();

        // 1. Validasi format dasar (tipe data, required, dll)
        $validator = Validator::make($request->all(), [
            'jenis_izin'       => 'required|in:sakit,cuti', // fix: 'izin' dibuang, gak ada di enum DB
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'       => 'required|string|max:1000',
            'surat_keterangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 2. Validasi aturan tanggal khusus (cuti H-7, sakit maks 3 hari)
        $validator->after(function ($validator) use ($request) {
            $this->validateAturanTanggal($validator, $request);
        });

        // 3. Kalau ada error, balik ke form dengan pesan error + input lama
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // 4. Upload file (kalau ada)
        $path = null;
        if ($request->hasFile('surat_keterangan')) {
            $path = $request->file('surat_keterangan')->store('surat_keterangan', 'public');
        }

        // 5. Simpan — karyawan_id SELALU dari session, bukan dari input user
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

    /**
     * Cek aturan bisnis tanggal untuk masing-masing jenis izin.
     * Dipisah dari store() biar method store() gak kepanjangan
     * dan logic ini gampang dites/dibaca sendiri.
     */
    private function validateAturanTanggal($validator, Request $request): void
    {
        $jenisIzin = $request->input('jenis_izin');
        $tanggalMulaiRaw = $request->input('tanggal_mulai');

        if (!$tanggalMulaiRaw) {
            return; // biarin rule 'required' di atas yang nangani
        }

        $tanggalMulai = Carbon::parse($tanggalMulaiRaw)->startOfDay();
        $hariIni = Carbon::today();

        if ($jenisIzin === 'cuti') {
            $minimalTanggal = $hariIni->copy()->addDays(self::MIN_HARI_CUTI);

            if ($tanggalMulai->lt($minimalTanggal)) {
                $validator->errors()->add(
                    'tanggal_mulai',
                    'Pengajuan cuti harus diajukan minimal ' . self::MIN_HARI_CUTI . ' hari sebelum tanggal mulai.'
                );
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
        }
    }

    public function destroy(Izin $izin)
    {
        $karyawan = $this->authKaryawan();

        abort_if($izin->karyawan_id !== $karyawan->id, 403);
        abort_if($izin->status !== 'pending', 403, 'Hanya pengajuan pending yang bisa dibatalkan.');

        // Bersihin file surat biar gak numpuk sampah di storage
        if ($izin->surat_keterangan) {
            Storage::disk('public')->delete($izin->surat_keterangan);
        }

        $izin->delete();

        return back()->with('success', 'Pengajuan izin berhasil dibatalkan.');
    }
}
