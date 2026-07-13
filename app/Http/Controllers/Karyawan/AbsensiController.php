<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Contracts\IKehadiran;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    protected IKehadiran $kehadiranService;

    public function __construct(IKehadiran $kehadiranService)
    {
        $this->kehadiranService = $kehadiranService;
    }

    /**
     * Ambil data Karyawan yang benar berdasarkan user yang sedang login.
     */
    private function getKaryawanAktif()
    {
        $user = Auth::guard('karyawan')->user();
        return Karyawan::where('user_id', $user->id)->firstOrFail();
    }

    public function formCheckIn()
    {
        $karyawan = $this->getKaryawanAktif();

        $cutoff = Carbon::today()->setTime(4, 0, 0);
        $effectiveDate = Carbon::now()->lt($cutoff) ? Carbon::yesterday()->toDateString() : Carbon::today()->toDateString();

        $kehadiranHariIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $effectiveDate)
            ->first();

        $sudahCheckIn = $kehadiranHariIni && $kehadiranHariIni->jam_masuk;
        $sudahCheckOut = $kehadiranHariIni && $kehadiranHariIni->jam_keluar;

        $riwayat = $this->kehadiranService->riwayat($karyawan);

        return view('pages.karyawan.absensi', compact(
            'karyawan',
            'sudahCheckIn',
            'sudahCheckOut',
            'kehadiranHariIni',
            'riwayat'
        ));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $karyawan = $this->getKaryawanAktif();

        $hasil = $this->kehadiranService->checkIn(
            $karyawan,
            (float) $request->latitude,
            (float) $request->longitude
        );

        return redirect()->back()->with(
            $hasil['success'] ? 'success' : 'error',
            $hasil['message']
        );
    }

    public function formCheckOut()
    {
        return redirect('/karyawan/checkin');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $karyawan = $this->getKaryawanAktif();

        $hasil = $this->kehadiranService->checkOut(
            $karyawan,
            (float) $request->latitude,
            (float) $request->longitude
        );

        return redirect()->back()->with(
            $hasil['success'] ? 'success' : 'error',
            $hasil['message']
        );
    }

    public function riwayat()
    {
        $karyawan = $this->getKaryawanAktif();

        // Untuk kebutuhan: jika belum check-in di hari efektif, tampilkan data baru: tidak hadir (alpha)
        $cutoff = Carbon::today()->setTime(4, 0, 0);
        $effectiveDate = Carbon::now()->lt($cutoff) ? Carbon::yesterday()->toDateString() : Carbon::today()->toDateString();

        $kehadiranHariIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $effectiveDate)
            ->first();

        if (!$kehadiranHariIni) {
            // cek apakah ada izin approved yang mencakup tanggal efektif
            $izinApproved = Izin::where('karyawan_id', $karyawan->id)
                ->where('status', 'approved')
                ->whereDate('tanggal_mulai', '<=', $effectiveDate)
                ->whereDate('tanggal_selesai', '>=', $effectiveDate)
                ->first();

            // Hindari duplikasi: hanya buat record jika belum ada untuk tanggal efektif
            Kehadiran::updateOrCreate(
                [
                    'karyawan_id' => $karyawan->id,
                    'tanggal' => $effectiveDate,
                ],
                [
                    'status' => $izinApproved ? ucfirst($izinApproved->jenis_izin) : 'Tidak Hadir',
                    'keterangan' => $izinApproved?->keterangan,
                ]
            );
        }

        $riwayat = $this->kehadiranService->riwayat($karyawan);

        return view('pages.karyawan.riwayat', compact('riwayat'));
    }
}