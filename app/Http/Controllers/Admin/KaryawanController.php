<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('divisi')->get();
        $divisi   = Divisi::all();

        return view('pages.admin.karyawan', [
            'karyawan' => $karyawan,
            'divisi'   => $divisi,
            'role'     => 'admin',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'       => 'required|unique:karyawans,nip',
            'nama'      => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'karyawan',
        ]);

        Karyawan::create([
            'user_id'   => $user->id,
            'nip'       => $request->nip,
            'nama'      => $request->nama,
            'divisi_id' => $request->divisi_id,
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nip'       => 'required|unique:karyawans,nip,' . $karyawan->id,
            'nama'      => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
        ]);

        $karyawan->update([
            'nip'       => $request->nip,
            'nama'      => $request->nama,
            'divisi_id' => $request->divisi_id,
        ]);

        // Update nama di tabel users 
        if ($karyawan->user) {
            $karyawan->user->update([
                'nama' => $request->nama,
            ]);
        }

        return redirect()->back()->with('success', 'Karyawan berhasil diupdate.');
    }

    public function updateStatus($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->status = $karyawan->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $karyawan->save();

        return redirect()->back()->with('success', 'Status karyawan berhasil diubah.');
    }

    public function destroy(Karyawan $karyawan)
    {
        // Hapus user 
        if ($karyawan->user) {
            $karyawan->user->delete();
        }

        $karyawan->delete();

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus.');
    }
}
