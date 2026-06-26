<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Karyawan\IzinController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ApprovalController;

Route::get('/', function () {
    return view('landing');
});

// login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// login process
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// middleware admin
Route::prefix('admin')
    ->middleware('auth:admin')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Divisi Resource
        Route::resource('/divisi', DivisiController::class);

        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        Route::patch('/karyawan/{id}/status', [KaryawanController::class, 'updateStatus'])
            ->name('karyawan.status');

        Route::get('/approval', [ApprovalController::class, 'index'])
            ->name('admin.approval.index');

        Route::patch('/approval/{izin}/approve', [ApprovalController::class, 'approve'])
            ->name('admin.approval.approve');

        Route::patch('/approval/{izin}/reject', [ApprovalController::class, 'reject'])
            ->name('admin.approval.reject');
    });

// middleware karyawan
Route::prefix('karyawan')
    ->middleware('auth:karyawan')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'dashboard']);

        // Absensi
        Route::get('/checkin', [AbsensiController::class, 'formCheckIn']);
        Route::post('/checkin', [AbsensiController::class, 'checkIn']);

        Route::get('/checkout', [AbsensiController::class, 'formCheckOut']);
        Route::post('/checkout', [AbsensiController::class, 'checkOut']);

        // Izin Karyawan
        Route::get('/izin', [IzinController::class, 'index']);
        Route::post('/izin', [IzinController::class, 'store']);

        Route::delete('/izin/{izin}', [IzinController::class, 'destroy'])
            ->name('karyawan.izin.destroy');
    });
