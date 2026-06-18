<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        // ✅ Coba login sebagai admin
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $user = Auth::guard('admin')->user();

            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }

            // Role bukan admin? logout paksa
            Auth::guard('admin')->logout();
        }

        // ✅ Coba login sebagai karyawan
        if (Auth::guard('karyawan')->attempt($credentials, $remember)) {
            $user = Auth::guard('karyawan')->user();

            if ($user->role === 'karyawan') {
                $request->session()->regenerate();
                return redirect('/karyawan/dashboard');
            }

            // Role bukan karyawan? logout paksa
            Auth::guard('karyawan')->logout();
        }

        // ❌ Keduanya gagal
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // ✅ Logout dari kedua guard sekaligus
        Auth::guard('admin')->logout();
        Auth::guard('karyawan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
