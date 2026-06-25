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
        $emailLama = $karyawan->email;

        $user = \App\Models\User::where('email', $emailLama)->first();
        $userId = $user ? $user->id : null;

        $request->validate([
            'nama' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'email' => 'required|email|unique:users,email,' . ($userId ?? 'NULL') . '|unique:karyawan,email,' . $karyawan->getKey(),
            'password' => 'nullable|min:6',
        ]);

        Karyawan::whereKey($karyawan->getKey())->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
        ]);


        if ($user) {
            $userData = [
                'name' => $request->nama,
                'email' => $request->email, 
            ];

            if ($request->filled('password')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $user->update($userData);
        } else {
            $passwordDefault = $request->filled('password') ? $request->password : 'karyawan123';

            $user = \App\Models\User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($passwordDefault),
                'role' => 'karyawan',
            ]);
        }

        \App\Models\Karyawan::where($karyawan->getKeyName(), $karyawan->getKey())
            ->update([
                'nama' => $request->nama,
                'email' => $request->email, 
                'divisi_id' => $request->divisi_id,
            ]);

        return redirect()->back()->with('success', 'Karyawan dan password berhasil diupdate.');
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
        \App\Models\User::where('email', $karyawan->email)->delete();

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