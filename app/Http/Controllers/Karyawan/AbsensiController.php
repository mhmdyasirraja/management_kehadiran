<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // ✅ Tambah ini

class AbsensiController extends Controller
{
    public function formCheckIn()
    {
        $karyawan = Auth::guard('karyawan')->user(); // ✅ Fix

        $kehadiranHariIni = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $sudahCheckIn  = $kehadiranHariIni && $kehadiranHariIni->jam_check_in;
        $sudahCheckOut = $kehadiranHariIni && $kehadiranHariIni->jam_check_out;

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
        $karyawan = Auth::guard('karyawan')->user(); // ✅ Fix

        $sudahCheckIn = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        if ($sudahCheckIn) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan check-in hari ini');
        }

        Kehadiran::create([
            'karyawan_id'  => $karyawan->id,
            'tanggal'      => Carbon::today(),
            'jam_check_in' => Carbon::now()->toTimeString(),
            'status'       => 'hadir',
        ]);

        return redirect()->back()
            ->with('success', 'Check-in berhasil pukul ' . Carbon::now()->format('H:i'));
    }

    public function formCheckOut()
    {
        return redirect('/karyawan/checkin'); // ✅ Fix URL sesuai route
    }

    public function checkOut(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user(); // ✅ Fix

        $kehadiran = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if (!$kehadiran) {
            return redirect()->back()
                ->with('error', 'Anda belum melakukan check-in hari ini');
        }

        if ($kehadiran->jam_check_out) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan check-out hari ini');
        }

        $jamKeluar = Carbon::now();

        $kehadiran->update([
            'jam_check_out' => $jamKeluar->toTimeString(),
        ]);

        return redirect()->back()
            ->with('success', 'Check-out berhasil pukul ' . $jamKeluar->format('H:i'));
    }
}
