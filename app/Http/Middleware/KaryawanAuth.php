<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('karyawan')->check()) {
            return redirect('/login')->withErrors(['email' => 'Silakan login sebagai karyawan.']);
        }

        return $next($request);
    }
}
