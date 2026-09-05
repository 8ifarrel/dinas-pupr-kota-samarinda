<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedKelurahan
{
    /**
     * Jika akun kelurahan sudah login, jangan tampilkan halaman login lagi.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('kelurahan')->check()) {
            return redirect()->route('guest.drainase-irigasi.index');
        }

        return $next($request);
    }
}
