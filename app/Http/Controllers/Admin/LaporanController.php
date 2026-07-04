<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Karyawan;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = Kehadiran::with('karyawan')->orderBy('tanggal', 'desc');

        if ($request->filled('nama')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $laporan = $this->buildQuery($request)->paginate(20)->withQueryString();
        $karyawans = Karyawan::orderBy('nama')->get();

        return view('pages.admin.laporan', compact('laporan', 'karyawans'));
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