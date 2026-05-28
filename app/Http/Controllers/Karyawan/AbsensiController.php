<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;

class AbsensiController extends Controller
{
    public function checkIn()
    {
        $karyawan = Karyawan::first();

        if (!$karyawan) {
            return 'Data karyawan tidak ditemukan';
        }

        $hasil = $karyawan->checkIn('1.123,104.222');

        return response()->json($hasil);
    }
}
