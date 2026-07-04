<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = Kehadiran::with('karyawan.divisi')->orderBy('tanggal', 'desc');

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Filter Karyawan (berdasarkan ID, bukan nama — lebih presisi)
        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        // Filter Divisi
        if ($request->filled('divisi_id')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('divisi_id', $request->divisi_id);
            });
        }

        // Filter Status (tetap dipertahankan, opsional)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $laporan = $this->buildQuery($request)->paginate(20)->withQueryString();
        $karyawans = Karyawan::orderBy('nama')->get();
        $divisis = Divisi::orderBy('nama')->get();

        return view('pages.admin.laporan', compact('laporan', 'karyawans', 'divisis'));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->buildQuery($request)->get();

        $pdf = Pdf::loadView('pages.admin.laporan-pdf', ['data' => $data])
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-absensi-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->buildQuery($request)->get();

        return Excel::download(
            new LaporanExport($data),
            'laporan-absensi-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}