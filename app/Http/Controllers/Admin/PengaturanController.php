<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();

        $jamKerja = [
            'checkin_mulai'    => Pengaturan::get('checkin_mulai', '06:00'),
            'checkin_selesai'  => Pengaturan::get('checkin_selesai', '09:00'),
            'checkout_mulai'   => Pengaturan::get('checkout_mulai', '16:00'),
            'checkout_selesai' => Pengaturan::get('checkout_selesai', '19:00'),
        ];

        return view('pages.admin.pengaturan', compact('lokasis', 'jamKerja'));
    }

    public function storeLokasi(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'radius'      => 'required|integer|min:10|max:5000',
        ]);

        Lokasi::create($validated);

        return back()->with('success', 'Lokasi kantor berhasil ditambahkan.');
    }

    public function updateLokasi(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'radius'      => 'required|integer|min:10|max:5000',
        ]);

        $lokasi->update($validated);

        return back()->with('success', 'Lokasi kantor berhasil diperbarui.');
    }

    public function destroyLokasi(Lokasi $lokasi)
    {
        $lokasi->delete();

        return back()->with('success', 'Lokasi kantor berhasil dihapus.');
    }

    public function updateJamKerja(Request $request)
    {
        $validated = $request->validate([
            'checkin_mulai'    => 'required|date_format:H:i',
            'checkin_selesai'  => 'required|date_format:H:i|after:checkin_mulai',
            'checkout_mulai'   => 'required|date_format:H:i',
            'checkout_selesai' => 'required|date_format:H:i|after:checkout_mulai',
        ], [
            'checkin_selesai.after'  => 'Jam selesai check-in harus setelah jam mulai.',
            'checkout_selesai.after' => 'Jam selesai check-out harus setelah jam mulai.',
        ]);

        foreach ($validated as $key => $value) {
            Pengaturan::set($key, $value);
        }

        return back()->with('success', 'Jam kerja berhasil diperbarui.');
    }
}