<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'login');
Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard');
    Route::view('/divisi', 'admin.divisi');
    Route::view('/karyawan', 'admin.karyawan');
    Route::view('/approval', 'admin.approval');
    Route::view('/laporan', 'admin.laporan');
    Route::view('/pengaturan', 'admin.pengaturan');
});

Route::prefix('karyawan')->group(function () {

    Route::view('/dashboard', 'karyawan.dashboard');
    Route::view('/absensi', 'karyawan.absensi');
    Route::view('/perizinan', 'karyawan.pengajuan');
    Route::view('/riwayat', 'karyawan.riwayat');
});
