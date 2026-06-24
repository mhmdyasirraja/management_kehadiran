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

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $user = Auth::guard('admin')->user();

            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }

            Auth::guard('admin')->logout();
        }

        if (Auth::guard('karyawan')->attempt($credentials, $remember)) {
            $user = Auth::guard('karyawan')->user();

            if ($user->role === 'karyawan') {
                $request->session()->regenerate();
                return redirect('/karyawan/dashboard');
            }

            Auth::guard('karyawan')->logout();
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('karyawan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
