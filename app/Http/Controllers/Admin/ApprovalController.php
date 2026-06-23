<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('status', 'pending');
        $search = $request->get('search', '');

        $izin = izin::with('karyawan')
            ->where('status', $filter)
            ->whereHas('karyawan', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->oldest()
            ->get();

        return view('pages.admin.approval', compact('izin', 'filter', 'search'));
    }

    public function approve(Izin $izin)
    {
        $izin->update([
            'status' => 'approved',
            'approved_by' => auth('admin')->user()->id,
        ]);

        return redirect()->route('admin.approval.index')
            ->with('success', 'Perizinan berhasil disetujui.');
    }

    public function reject(Izin $izin)
    {
        $izin->update([
            'status' => 'rejected',
            'approved_by' => auth('admin')->user()->id,
        ]);

        return redirect()->route('admin.approval.index')
            ->with('success', 'Perizinan berhasil ditolak.');
    }
}
