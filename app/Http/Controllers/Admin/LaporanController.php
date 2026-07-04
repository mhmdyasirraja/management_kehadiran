<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Izin;
use App\Models\Karyawan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->filled('tanggal_awal') ? $request->tanggal_awal : null;
        $tanggalAkhir = $request->filled('tanggal_akhir') ? $request->tanggal_akhir : null;

        // 1. Ambil data KEHADIRAN
        $kehadiranQuery = Kehadiran::with('karyawan');

        if ($tanggalAwal && $tanggalAkhir) {
            $kehadiranQuery->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        }

        $dataKehadiran = $kehadiranQuery->get()->map(function ($item) {
            return (object) [
                'nama_karyawan' => $item->karyawan->nama ?? '-',
                'tanggal' => $item->tanggal,
                'jam_masuk' => $item->jam_masuk,
                'jam_keluar' => $item->jam_keluar,
                'status' => $item->status, // 'hadir' atau 'alpha' kalau ada job generate alpha
                'keterangan' => null,
            ];
        });

        // 2. Ambil data IZIN/SAKIT yang sudah di-approve, lalu expand per tanggal
        $izinQuery = Izin::with('karyawan')->where('status', 'approved');

        if ($tanggalAwal && $tanggalAkhir) {
            $izinQuery->where(function ($q) use ($tanggalAwal, $tanggalAkhir) {
                $q->whereBetween('tanggal_mulai', [$tanggalAwal, $tanggalAkhir])
                  ->orWhereBetween('tanggal_selesai', [$tanggalAwal, $tanggalAkhir])
                  ->orWhere(function ($q2) use ($tanggalAwal, $tanggalAkhir) {
                      $q2->where('tanggal_mulai', '<=', $tanggalAwal)
                         ->where('tanggal_selesai', '>=', $tanggalAkhir);
                  });
            });
        }

        $dataIzin = collect();

        foreach ($izinQuery->get() as $izin) {
            $periode = CarbonPeriod::create($izin->tanggal_mulai, $izin->tanggal_selesai);

            foreach ($periode as $tanggal) {
                // Kalau ada filter rentang tanggal, pastikan tanggal hasil expand tetap dalam rentang itu
                if ($tanggalAwal && $tanggalAkhir) {
                    if ($tanggal->lt(Carbon::parse($tanggalAwal)) || $tanggal->gt(Carbon::parse($tanggalAkhir))) {
                        continue;
                    }
                }

                $dataIzin->push((object) [
                    'nama_karyawan' => $izin->karyawan->nama ?? '-',
                    'tanggal' => $tanggal->toDateString(),
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                    'status' => $izin->jenis_izin, // 'izin' atau 'sakit'
                    'keterangan' => $izin->keterangan,
                ]);
            }
        }

        // 3. Gabungkan semua data
        $gabungan = $dataKehadiran->concat($dataIzin);

        // 4. Filter berdasarkan nama (kalau dipilih)
        if ($request->filled('nama')) {
            $gabungan = $gabungan->filter(function ($item) use ($request) {
                return stripos($item->nama_karyawan, $request->nama) !== false;
            });
        }

        // 5. Filter berdasarkan status (kalau dipilih)
        if ($request->filled('status')) {
            $gabungan = $gabungan->filter(function ($item) use ($request) {
                return $item->status === $request->status;
            });
        }

        // 6. Urutkan berdasarkan tanggal terbaru
        $gabungan = $gabungan->sortByDesc('tanggal')->values();

        // 7. Paginate manual (karena data dari Collection, bukan query builder)
        $perPage = 20;
        $currentPage = $request->get('page', 1);
        $items = $gabungan->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $laporan = new LengthAwarePaginator(
            $items,
            $gabungan->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $karyawans = Karyawan::orderBy('nama')->get();

        return view('pages.admin.laporan', compact('laporan', 'karyawans'));
    }
}