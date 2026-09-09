<?php

namespace App\Http\Middleware;

use App\Support\Shared\StatusLoginKelurahan;
use Closure;
use Illuminate\Http\Request;

class AuthenticateKelurahan
{
  /**
   * Pastikan pengunjung sudah login sebelum dapat mengakses fitur Drainase
   * dan Irigasi (Hantu Banyu).
   *
   * Dua macam akun diterima: akun kelurahan (guard 'kelurahan') yang
   * terkunci di wilayahnya sendiri, dan akun admin E-Panel (guard 'web')
   * yang boleh mengakses seluruh kelurahan. Karena keduanya berbagi session
   * yang sama, admin yang sudah login di E-Panel langsung dikenali di sini
   * tanpa perlu login dua kali.
   */
  public function handle(Request $request, Closure $next)
  {
    if (!StatusLoginKelurahan::adaYangLogin()) {
      return redirect()
        ->route('guest.hantu-banyu.login.index')
        ->with('error', 'Silakan login dengan akun kelurahan atau akun admin terlebih dahulu.');
    }

    return $next($request);
  }
}
