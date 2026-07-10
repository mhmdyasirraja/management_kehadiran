<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    // Ambil semua data dari DB
    public function index(Request $request)
    {
        // filter cari divisi
        $search = $request->query('search');

        // hitung jumlah karyawan per divisi secara otomatis
        $divisi = Divisi::withCount(['karyawan' => function ($query) {
            $query->aktif();
        }])
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->oldest()
            ->get();

        return view('pages.admin.divisi', [
            'divisi' => $divisi,

            'search' => $search,
        ]);
    }

    // tambah divisi baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Divisi::create($request->only('nama', 'deskripsi'));

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    // Update divisi
    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $divisi->update($request->only('nama', 'deskripsi'));

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diupdate.');
    }

    // Hapus divisi
    public function destroy(Divisi $divisi)
    {
        if ($divisi->karyawan()->exists()) {
            return redirect()->route('divisi.index')
                ->with('error', 'Divisi tidak bisa dihapus karena masih memiliki data karyawan.');
        }
        $divisi->delete();

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
