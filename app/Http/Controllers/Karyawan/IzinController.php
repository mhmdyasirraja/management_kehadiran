<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;
use App\Models\Karyawan;

class IzinController extends Controller
{
    private function authUser()
    {
        return Auth::guard('karyawan')->user();
    }

    private function authKaryawan()
    {
        /** @var \App\Models\User $user */
        $user = $this->authUser();
        /** @var \App\Models\Karyawan $karyawan */
        $karyawan = Karyawan::where('user_id', $user->id)->firstOrFail();
        return $karyawan;
    }

    public function index()
    {
        $karyawan = $this->authKaryawan();

        $izin = Izin::where('karyawan_id', $karyawan->id)
            ->latest()
            ->get();

        $total   = $izin->count();
        $pending = $izin->where('status', 'pending')->count();
        $selesai = $izin->whereIn('status', ['approved', 'rejected'])->count();

        return view('pages.karyawan.pengajuan', compact('izin', 'total', 'pending', 'selesai'));
    }

    public function store(Request $request)
    {
        $karyawan = $this->authKaryawan();

        $request->validate([
            'jenis_izin'       => 'required|in:sakit,izin,cuti',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'       => 'required|string',
            'surat_keterangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('surat_keterangan')) {
            $path = $request->file('surat_keterangan')->store('surat_keterangan', 'public');
        }

        Izin::create([
            'karyawan_id'      => $karyawan->id,
            'jenis_izin'       => $request->jenis_izin,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'keterangan'       => $request->keterangan,
            'surat_keterangan' => $path,
            'status'           => 'pending',
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function destroy(Izin $izin)
    {
        $karyawan = $this->authKaryawan();

        abort_if($izin->karyawan_id !== $karyawan->id, 403);
        abort_if($izin->status !== 'pending', 403, 'Hanya pengajuan pending yang bisa dibatalkan.');

        $izin->delete();

        return back()->with('success', 'Pengajuan izin berhasil dibatalkan.');
    }
}
