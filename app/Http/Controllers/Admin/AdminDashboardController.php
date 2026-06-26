<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Karyawan;
use App\Models\Izin;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ─── SUMMARY CARDS ────────────────────────────────────────

        $totalKaryawan = Karyawan::count();

        // Hadir: dari tabel kehadiran, status 'Hadir', tanggal hari ini
        $hadirHariIni = Kehadiran::whereDate('tanggal', $today)
            ->where('status', 'Hadir')
            ->count();

        // Izin: dari tabel izin, status 'approved',
        // dan rentang tanggal mencakup hari ini
        $izinHariIni = Izin::where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->count();

        // Tidak hadir = sisa karyawan yang tidak hadir dan tidak izin
        $tidakHadir = max(0, $totalKaryawan - $hadirHariIni - $izinHariIni);

        // ─── DONUT CHART ──────────────────────────────────────────

        $donutData = [$hadirHariIni, $izinHariIni, $tidakHadir];

        // ─── BAR CHART — Tren 7 hari terakhir ────────────────────

        $startDate = Carbon::today()->subDays(6);

        // Ambil data kehadiran 7 hari dalam satu query
        $kehadiranRaw = Kehadiran::selectRaw('tanggal, status, COUNT(*) as total')
            ->whereBetween('tanggal', [$startDate, $today])
            ->groupBy('tanggal', 'status')
            ->orderBy('tanggal')
            ->get();

        // Ambil data izin 7 hari dalam satu query
        $izinRaw = Izin::selectRaw('DATE(tanggal_mulai) as tanggal, COUNT(*) as total')
            ->where('status', 'approved')
            ->whereBetween('tanggal_mulai', [$startDate, $today])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $barLabels     = [];
        $barHadir      = [];
        $barIzin       = [];
        $barTidakHadir = [];

        for ($i = 6; $i >= 0; $i--) {
            $date    = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');

            $barLabels[] = $date->locale('id')->isoFormat('ddd');

            $dayData = $kehadiranRaw->where('tanggal', $dateStr);

            $hadir      = (int) optional($dayData->where('status', 'Hadir')->first())->total;
            $izin       = (int) optional($izinRaw->get($dateStr))->total;
            $tidakHadirBar = max(0, $totalKaryawan - $hadir - $izin);

            $barHadir[]      = $hadir;
            $barIzin[]       = $izin;
            $barTidakHadir[] = $tidakHadirBar;
        }

        // ─── TABEL ABSENSI TERBARU ────────────────────────────────

        $absensiTerbaru = Kehadiran::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->limit(10)
            ->get();

        return view('pages.admin.dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'izinHariIni',
            'tidakHadir',
            'donutData',
            'barLabels',
            'barHadir',
            'barIzin',
            'barTidakHadir',
            'absensiTerbaru',
        ));
    }
}
