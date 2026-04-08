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
});
