<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silahkan log in untuk mengakses halaman');
        }

        // Ambil role user yang login
        $userRole = Auth::user()->role;

        // Periksa apakah role user ada di dalam daftar role yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Jika role user tidak diizinkan, logout dan redirect ke login
            auth()->logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki hak akses ke halaman ini');
        }

        return $next($request);
    }
}
