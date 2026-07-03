<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Contracts\IKehadiran;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    protected IKehadiran $kehadiranService;

    // Interface di-inject otomatis oleh Laravel (lihat AppServiceProvider)
    public function __construct(IKehadiran $kehadiranService)
    {
        $this->kehadiranService = $kehadiranService;
    }

    public function formCheckIn()
    {
        $karyawan = Auth::guard('karyawan')->user();

        $kehadiranHariIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $sudahCheckIn = $kehadiranHariIni && $kehadiranHariIni->jam_masuk;
        $sudahCheckOut = $kehadiranHariIni && $kehadiranHariIni->jam_keluar;

        // Riwayat otomatis sesuai user login (karyawan_id)
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
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $karyawan = Auth::guard('karyawan')->user();

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
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $karyawan = Auth::guard('karyawan')->user();

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
        $karyawan = Auth::guard('karyawan')->user();
        $riwayat = $this->kehadiranService->riwayat($karyawan);

        return view('pages.karyawan.riwayat', compact('riwayat'));
    }
}