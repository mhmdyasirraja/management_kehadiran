<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB; // tambah ini
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
        $karyawan = Karyawan::with(['divisi', 'user'])->get();
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
            'nama'      => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama, 
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'karyawan',
            ]);

            Karyawan::create([
                'user_id'   => $user->id,
                'nama'      => $request->nama,
                'divisi_id' => $request->divisi_id,
                'status'    => 'aktif',
                'nip'       => $this->generateNip(),
            ]);
        });

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisi,id',
            'email'     => 'required|email|unique:users,email,' . $karyawan->user_id,
            'password'  => 'nullable|min:6',
        ]);

        DB::transaction(function () use ($request, $karyawan) {
            $karyawan->update([
                'nama'      => $request->nama,
                'divisi_id' => $request->divisi_id,
            ]);

            if ($karyawan->user) {
                $userData = ['email' => $request->email];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $karyawan->user->update($userData);
            }
        });

        return redirect()->back()->with('success', 'Karyawan berhasil diupdate.');
    }

    public function destroy(Karyawan $karyawan)
    {
        DB::transaction(function () use ($karyawan) {
            $user = $karyawan->user; 

            $karyawan->delete(); 

            if ($user) {
                $user->delete(); 
            }
        });

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus.');
    }

    public function updateStatus($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->status = $karyawan->status === 'aktif' ? 'nonaktif' : 'aktif';
        $karyawan->save();

        return redirect()->back()->with('success', 'Status karyawan berhasil diubah.');
    }

    private function generateNip(): string
    {
        $tahun = date('Y');

        $last = Karyawan::where('nip', 'like', $tahun . '%')
            ->orderBy('nip', 'desc')
            ->first();

        $urutan = $last ? ((int) substr($last->nip, 4)) + 1 : 1;

        return $tahun . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }
}
