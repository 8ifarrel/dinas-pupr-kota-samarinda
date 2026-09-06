<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateKelurahan
{
  /**
   * Pastikan pengunjung sudah login menggunakan akun kelurahan
   * sebelum dapat mengakses fitur Drainase dan Irigasi (Hantu Banyu).
   */
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::guard('kelurahan')->check()) {
      return redirect()
        ->route('guest.hantu-banyu.login.index')
        ->with('error', 'Silakan login dengan akun kelurahan terlebih dahulu.');
    }

    return $next($request);
  }
}
