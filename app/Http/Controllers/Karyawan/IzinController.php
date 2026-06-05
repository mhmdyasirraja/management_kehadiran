<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;

class IzinController extends Controller
{
    public function index()
    {
        return view('pages.karyawan.pengajuan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required'
        ]);

        Izin::create([
            'karyawan_id' => auth()->id(),
            'jenis_izin' => $request->jenis_izin,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan izin berhasil disimpan');
    }
}