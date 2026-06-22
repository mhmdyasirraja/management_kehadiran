<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
    public function dashboard()
    {
        $karyawan          = Auth::guard('karyawan')->user(); // ✅ Fix di sini
        $kehadiranBulanIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $izinPending = Izin::where('karyawan_id', $karyawan->id)
            ->where('status', 'pending')
            ->count();

        $kehadiranHariIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $statusHariIni = $kehadiranHariIni
            ? ($kehadiranHariIni->jam_check_out
                ? 'Sudah Check-out'
                : 'Sudah Check-in')
            : 'Belum Check-in';

        $riwayat = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pages.karyawan.dashboard', compact(
            'karyawan',
            'kehadiranBulanIni',
            'izinPending',
            'statusHariIni',
            'kehadiranHariIni',
            'riwayat'
        ));
    }
}
