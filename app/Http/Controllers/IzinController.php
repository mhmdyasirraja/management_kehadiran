<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function form()
    {
        $karyawan = auth()->user();
        $bulanIni = now()->month;

        $terpakai_izin = Izin::where('karyawan_id', $karyawan->id)
            ->where('jenis_izin', 'izin')
            ->whereIn('status', ['pending', 'disetujui'])
            ->whereMonth('tanggal_mulai', $bulanIni)
            ->sum('jumlah_hari');

        $terpakai_sakit = Izin::where('karyawan_id', $karyawan->id)
            ->where('jenis_izin', 'sakit')
            ->whereIn('status', ['pending', 'disetujui'])
            ->whereMonth('tanggal_mulai', $bulanIni)
            ->sum('jumlah_hari');

        $sisa_izin  = Izin::MAX_HARI_IZIN  - $terpakai_izin;
        $sisa_sakit = Izin::MAX_HARI_SAKIT - $terpakai_sakit;

        return view('izin.form', compact(
            'karyawan',
            'sisa_izin',
            'sisa_sakit',
            'terpakai_izin',
            'terpakai_sakit'
        ));
    }

    public function ajukan(Request $request)
    {
        $request->validate([
            'jenis_izin'      => 'required|in:izin,sakit',
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'required|string|min:10',
            'surat_keterangan'=> 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'jenis_izin.required'       => 'Jenis izin wajib dipilih',
            'tanggal_mulai.required'    => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini',
            'tanggal_selesai.required'  => 'Tanggal selesai wajib diisi',
            'keterangan.required'       => 'Keterangan wajib diisi',
            'keterangan.min'            => 'Keterangan minimal 10 karakter',
            'surat_keterangan.mimes'    => 'File harus berformat PDF, JPG, atau PNG',
            'surat_keterangan.max'      => 'Ukuran file maksimal 2MB',
        ]);

        $karyawan    = auth()->user();
        $jumlahHari  = Izin::hitungHari(
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        $izinModel = new Izin();
        if (!$izinModel->cekBatasHari($karyawan->id, $request->jenis_izin, $jumlahHari)) {
            $max = $request->jenis_izin === 'sakit'
                ? Izin::MAX_HARI_SAKIT
                : Izin::MAX_HARI_IZIN;
            return back()
                ->withInput()
                ->with('error', "Melebihi batas maksimal {$max} hari untuk {$request->jenis_izin} bulan ini");
        }

        $suratPath = null;
        if ($request->hasFile('surat_keterangan')) {
            $suratPath = $request->file('surat_keterangan')
                ->store('surat-keterangan', 'public');
        }

        if ($request->jenis_izin === 'sakit' && !$suratPath) {
            return back()
                ->withInput()
                ->with('error', 'Surat keterangan sakit wajib dilampirkan');
        }

        Izin::create([
            'karyawan_id'      => $karyawan->id,
            'jenis_izin'       => $request->jenis_izin,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'jumlah_hari'      => $jumlahHari,
            'keterangan'       => $request->keterangan,
            'surat_keterangan' => $suratPath,
            'status'           => 'pending',
        ]);

        return redirect('/karyawan/izin/riwayat')
            ->with('success', 'Pengajuan izin berhasil dikirim, menunggu persetujuan Admin HR');
    }

    public function riwayat()
    {
        $karyawan = auth()->user();

        $riwayat = Izin::where('karyawan_id', $karyawan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('izin.riwayat', compact('riwayat'));
    }

    public function index()
    {
        $pending   = Izin::with('karyawan')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayat = Izin::with('karyawan')
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('izin.index', compact('pending', 'riwayat'));
    }

    public function setujui(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update([
            'status'        => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        $tanggal = Carbon::parse($izin->tanggal_mulai);
        while ($tanggal <= Carbon::parse($izin->tanggal_selesai)) {
            Kehadiran::updateOrCreate(
                [
                    'karyawan_id' => $izin->karyawan_id,
                    'tanggal'     => $tanggal->toDateString(),
                ],
                ['status' => $izin->jenis_izin]
            );
            $tanggal->addDay();
        }

        return redirect('/admin/izin')
            ->with('success', 'Izin atas nama ' . $izin->karyawan->nama . ' telah disetujui');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string',
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi',
        ]);

        $izin = Izin::findOrFail($id);
        $izin->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect('/admin/izin')
            ->with('success', 'Izin atas nama ' . $izin->karyawan->nama . ' telah ditolak');
    }
}