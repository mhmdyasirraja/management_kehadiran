<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DivisiController extends Controller
{
    public function index()
    {
        $divisi = [
            [
                'id' => 1,
                'nama' => 'IT',
                'jumlah' => 10,
                'deskripsi' => 'Divisi Teknologi & Sistem',
                'tanggal' => '12 Feb 2026'
            ],
            [
                'id' => 2,
                'nama' => 'HRD',
                'jumlah' => 5,
                'deskripsi' => 'Manajemen SDM',
                'tanggal' => '10 Feb 2026'
            ],
            [
                'id' => 3,
                'nama' => 'Finance',
                'jumlah' => 7,
                'deskripsi' => 'Keuangan & Akuntansi',
                'tanggal' => '08 Feb 2026'
            ],
            [
                'id' => 4,
                'nama' => 'Marketing',
                'jumlah' => 6,
                'deskripsi' => 'Promosi & Branding',
                'tanggal' => '05 Feb 2026'
            ],
             [
                'id' => 5,
                'nama' => 'Digital Marketing',
                'jumlah' => 6,
                'deskripsi' => 'Promosi & Branding',
                'tanggal' => '06 Feb 2026'
            ],
        ];

        return view('pages.admin.divisi', [
            'divisi' => $divisi,
            'role' => 'admin'
        ]);
    }
}
