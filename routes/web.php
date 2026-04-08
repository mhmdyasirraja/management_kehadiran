<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'login');
Route::view('/dashboard', 'dashboard');
Route::prefix('management')->group(function () {
    Route::get('/divisi', function () {
        return view('management.divisi');
    })->name('management.divisi');

    Route::get('/karyawan', function () {
        return view('management.karyawan');
    })->name('management.karyawan');

    Route::get('/approval', function () {
        return view('management.approval');
        })->name('management.approval');
    });
Route::prefix('karyawan')->group(function () {
    Route::get('/absensi', function () {
        return view('karyawan.absensi');
        })->name('karyawan.absensi');

    Route::get('/laporan', function () {
        return view('karyawan.laporan');
        })->name('karyawan.laporan');

    Route::get('/pengajuan', function () {
        return view('karyawan.pengajuan');
        })->name('karyawan.pengajuan');

    Route::get('/riwayat', function () {
        return view('karyawan.riwayat');
        })->name('karyawan.riwayat');

    });