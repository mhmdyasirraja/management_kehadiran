<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Karyawan\IzinController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ApprovalController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN / LOGOUT) - TANPA GATEKEEPER DULU
|--------------------------------------------------------------------------
*/

// login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// login process
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (AKTIFKAN LAGI NANTI SETELAH LOGIN NORMAL)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard', ['role' => 'admin']);
    });

    Route::resource('/divisi', DivisiController::class);
    Route::resource('/karyawan', KaryawanController::class);

    Route::patch('/karyawan/{id}/status', [KaryawanController::class, 'updateStatus'])
        ->name('karyawan.status');

    Route::get('/approval', [ApprovalController::class, 'index'])
        ->name('admin.approval.index');

    Route::patch('/approval/{izin}/approve', [ApprovalController::class, 'approve'])
        ->name('admin.approval.approve');

    Route::patch('/approval/{izin}/reject', [ApprovalController::class, 'reject'])
        ->name('admin.approval.reject');

    Route::get('/laporan', function () {
        return view('pages.admin.laporan', ['role' => 'admin']);
    });

    Route::get('/pengaturan', function () {
        return view('pages.admin.pengaturan', ['role' => 'admin']);
    });
});

/*
|--------------------------------------------------------------------------
| KARYAWAN ROUTES (JUGA DINETRALIN DULU)
|--------------------------------------------------------------------------
*/
Route::prefix('karyawan')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('/checkin', [AbsensiController::class, 'formCheckIn']);
    Route::post('/checkin', [AbsensiController::class, 'checkIn']);

    Route::get('/checkout', [AbsensiController::class, 'formCheckOut']);
    Route::post('/checkout', [AbsensiController::class, 'checkOut']);

    Route::get('/izin', [IzinController::class, 'index']);
    Route::post('/izin', [IzinController::class, 'store']);

    Route::delete('/izin/{izin}', [IzinController::class, 'destroy'])
        ->name('karyawan.izin.destroy');

    Route::get('/riwayat', function () {
        return view('pages.karyawan.riwayat', ['role' => 'karyawan']);
    });
});
