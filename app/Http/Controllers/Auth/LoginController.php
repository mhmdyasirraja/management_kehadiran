<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        // 1. Cari dulu user berdasarkan email, cek role-nya SEBELUM mencoba attempt di guard manapun
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        // 2. Tentukan guard yang SESUAI berdasarkan role, baru attempt di guard itu SAJA
        $guard = match ($user->role) {
            'admin' => 'admin',
            'karyawan' => 'karyawan',
            default => null,
        };

        if (!$guard) {
            return back()
                ->withErrors(['email' => 'Role akun tidak dikenali.'])
                ->onlyInput('email');
        }

        // 3. Hanya attempt SATU KALI, di guard yang benar-benar sesuai — tidak menyentuh guard lain
        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $guard === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/karyawan/dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Tetap logout dari guard yang SEDANG aktif untuk request ini saja
        // Cek guard mana yang sedang dipakai berdasarkan halaman asal, bukan logout paksa keduanya
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}