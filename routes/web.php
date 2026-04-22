<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\KaryawanController;

// Route utama
//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/', function () {
    return view('landing');
});

// Route login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'pages.admin.dashboard', ['role' => 'admin']);
    Route::get('/divisi', [DivisiController::class, 'index']);
    Route::get('/karyawan', [KaryawanController::class, 'index']);
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
