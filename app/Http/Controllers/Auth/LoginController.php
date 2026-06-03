<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
            }
            return redirect('/karyawan/dashboard');
        }
        return back()->with('error', 'Email atau password salah');
    }
}
