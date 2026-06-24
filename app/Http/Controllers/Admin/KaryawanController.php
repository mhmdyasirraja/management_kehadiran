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
        $divisi = Divisi::all();

        return view('pages.admin.karyawan', [
            'karyawan' => $karyawan,
            'divisi' => $divisi,
            'role' => 'admin',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->nama, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        Karyawan::create([
            'id' => rand(100000, 999999),
            'nama' => $request->nama,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
            'status' => 'aktif',
            'nip' => $this->generateNip(), 
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
        ]);

        $karyawan->update([
            'nama' => $request->nama,
            'divisi_id' => $request->divisi_id,
        ]);

        if ($karyawan->user) {
            $karyawan->user->update([
                'name' => $request->nama,
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
        if ($karyawan->user) {
            $karyawan->user->delete();
        }

        $karyawan->delete();

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus.');
    }

    private function generateNip()
    {
        do {
            $nip = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Karyawan::where('nip', $nip)->exists());

        return $nip;
    }
}