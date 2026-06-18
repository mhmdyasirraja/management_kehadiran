<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Karyawan\IzinController;

Route::get('/', function () {
    return view('landing');
});

// ✅ Login — kalau udah login, redirect sesuai role
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

// ✅ Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Route ADMIN — wajib login sebagai admin
Route::middleware(['auth.admin'])
    ->prefix('admin')
    ->group(function () {
        Route::view('/dashboard', 'pages.admin.dashboard', ['role' => 'admin']);
        Route::resource('/divisi', DivisiController::class);
        Route::resource('/karyawan', KaryawanController::class);
        Route::patch('/karyawan/{id}/status', [KaryawanController::class, 'updateStatus'])
            ->name('karyawan.status');
        Route::view('/approval', 'pages.admin.approval', ['role' => 'admin']);
        Route::view('/laporan', 'pages.admin.laporan', ['role' => 'admin']);
        Route::view('/pengaturan', 'pages.admin.pengaturan', ['role' => 'admin']);
    });

// ✅ Route KARYAWAN — wajib login sebagai karyawan
Route::middleware(['auth.karyawan'])
    ->prefix('karyawan')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard']);
        Route::get('/absensi', [AbsensiController::class, 'formCheckIn']);
        Route::get('/checkin', [AbsensiController::class, 'formCheckIn']);
        Route::post('/checkin', [AbsensiController::class, 'checkIn']);
        Route::get('/checkout', [AbsensiController::class, 'formCheckOut']);
        Route::post('/checkout', [AbsensiController::class, 'checkOut']);
        Route::get('/izin', [IzinController::class, 'index']);
        Route::post('/izin', [IzinController::class, 'store']);
        Route::view('/riwayat', 'pages.karyawan.riwayat', ['role' => 'karyawan']);
    });
