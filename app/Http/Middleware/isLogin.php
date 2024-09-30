<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            // Jika sudah login, izinkan akses ke rute selanjutnya
            return $next($request);
        }

        // Jika belum login, hanya izinkan akses ke rute login
        if ($request->is('admin/login') || $request->is('admin/login/*')) {
            return $next($request);
        }

        // Jika akses ke rute lain selain login, redirect ke halaman login
        return redirect()->route('admin.login')->with('error', 'Please login first.');
    }
}
