<?php

use Illuminate\Support\Facades\Route;

// Route utama
Route::get('/', function () {
    return view('welcome');
});

// Route login
Route::view('/login', 'login');

Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'pages.admin.dashboard', ['role' => 'admin']);
    Route::view('/divisi', 'pages.admin.divisi', ['role' => 'admin']);
    Route::view('/karyawan', 'pages.admin.karyawan', ['role' => 'admin']);
    Route::view('/approval', 'pages.admin.approval', ['role' => 'admin']);
    Route::view('/laporan', 'pages.admin.laporan', ['role' => 'admin']);
    Route::view('/pengaturan', 'pages.admin.pengaturan', ['role' => 'admin']);
});

Route::prefix('karyawan')->group(function () {
    Route::view('/dashboard', 'pages.karyawan.dashboard', ['role' => 'karyawan']);
    Route::view('/absensi', 'pages.karyawan.absensi', ['role' => 'karyawan']);
    Route::view('/perizinan', 'pages.karyawan.pengajuan', ['role' => 'karyawan']);
    Route::view('/riwayat', 'pages.karyawan.riwayat', ['role' => 'karyawan']);
});
