<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = [
            [
                'id' => 'KRY001',
                'nama' => 'Muhammad Yasir',
                'divisi' => 'IT',
                'jabatan' => 'Backend Developer',
            ],
            [
                'id' => 'KRY002',
                'nama' => 'Andi',
                'divisi' => 'HRD',
                'jabatan' => 'HR Staff',
            ],
            [
                'id' => 'KRY003',
                'nama' => 'Budi',
                'divisi' => 'Finance',
                'jabatan' => 'Accountant',
            ],
            [
                'id' => 'KRY004',
                'nama' => 'Sinta',
                'divisi' => 'Marketing',
                'jabatan' => 'Content Specialist',
            ],
            [
                'id' => 'KRY005',
                'nama' => 'Ghani',
                'divisi' => 'Digital Marketing',
                'jabatan' => 'Content Specialist',
            ],
        ];

        $divisi = ['IT', 'HRD', 'Finance', 'Marketing'];

        return view('pages.admin.karyawan', [
            'karyawan' => $karyawan,
            'divisi' => $divisi,
            'role' => 'admin'
        ]);
    }
}
