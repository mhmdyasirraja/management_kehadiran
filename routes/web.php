<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Karyawan\IzinController;

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

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'pages.admin.dashboard', ['role' => 'admin']);

    Route::resource('/divisi', DivisiController::class);

    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::view('/approval', 'pages.admin.approval', ['role' => 'admin']);
    Route::view('/laporan', 'pages.admin.laporan', ['role' => 'admin']);
    Route::view('/pengaturan', 'pages.admin.pengaturan', ['role' => 'admin']);
});

Route::prefix('karyawan')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'formCheckIn']);
    Route::view('/riwayat', 'pages.karyawan.riwayat', ['role' => 'karyawan']);
});

Route::middleware(['auth'])
    ->prefix('karyawan')
    ->group(function () {
        Route::get('/dashboard',  [DashboardController::class, 'dashboard']);
        Route::get('/checkin', [AbsensiController::class, 'formCheckIn']);
        Route::post('/checkin', [AbsensiController::class, 'checkIn']);
        Route::get('/checkout', [AbsensiController::class, 'formCheckOut']);
        Route::post('/checkout', [AbsensiController::class, 'checkOut']);
        Route::get('/izin', [IzinController::class, 'index']);
        Route::post('/izin', [IzinController::class, 'store']);
    });
