<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Izin;

class ApprovalController extends Controller
{
    public function index()
    {
        $izin = Izin::with('karyawan')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->oldest() // ganti latest() → oldest()
            ->get();

        return view('pages.admin.approval', compact('izin'));
    }

    public function approve(Izin $izin)
    {
        $izin->update(['status' => 'approved']);

        return redirect()->route('admin.approval.index')
            ->with('success', 'Perizinan berhasil disetujui.');
    }

    public function reject(Izin $izin)
    {
        $izin->update(['status' => 'rejected']);

        return redirect()->route('admin.approval.index')
            ->with('success', 'Perizinan berhasil ditolak.');
    }
}
