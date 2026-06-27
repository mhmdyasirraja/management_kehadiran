<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function formCheckIn()
    {
        $karyawan = Auth::guard('karyawan')->user();

        $kehadiranHariIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $sudahCheckIn = $kehadiranHariIni && $kehadiranHariIni->jam_masuk;
        $sudahCheckOut = $kehadiranHariIni && $kehadiranHariIni->jam_keluar;

        $riwayat = Kehadiran::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->get();

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
        $karyawan = Auth::guard('karyawan')->user();

        // reset check in dan check out
        $cutoff = Carbon::today()->setTime(4, 0, 0);
        $effectiveDate = Carbon::now()->lt($cutoff) ? Carbon::yesterday()->toDateString() : Carbon::today()->toDateString();

        $sudahCheckIn = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $effectiveDate)
            ->exists();

        if ($sudahCheckIn) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan check-in hari ini');
        }

        $jamMasuk = Carbon::parse($effectiveDate . ' 07:00:00');
        $status = 'hadir';

        Kehadiran::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $effectiveDate,
            'jam_masuk' => $jamMasuk->toTimeString(),
            'status' => $status,
        ]);




        return redirect()->back()
            ->with('success', 'Check-in berhasil pukul ' . Carbon::now()->format('H:i'));
    }

    public function formCheckOut()
    {
        return redirect('/karyawan/checkin');
    }

    public function checkOut(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();

        $cutoff = Carbon::today()->setTime(4, 0, 0);
        $effectiveDate = Carbon::now()->lt($cutoff) ? Carbon::yesterday()->toDateString() : Carbon::today()->toDateString();

        $kehadiran = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $effectiveDate)
            ->first();


        if (!$kehadiran) {
            return redirect()->back()
                ->with('error', 'Anda belum melakukan check-in hari ini');
        }

        if ($kehadiran->jam_keluar) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan check-out hari ini');
        }

        $jamKeluar = Carbon::now();

        $jamKeluarStd = Carbon::parse($effectiveDate . ' 17:00:00');

        $kehadiran->update([
            'jam_keluar' => $jamKeluarStd->toTimeString(),
        ]);



        return redirect()->back()
            ->with('success', 'Check-out berhasil pukul 17:00');

    }

    public function riwayat()
    {
        $karyawan = Auth::guard('karyawan')->user();

        $riwayat = Kehadiran::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pages.karyawan.riwayat', compact('riwayat'));
    }
}




