<?php

namespace App\Http\Middleware;

use App\Support\Shared\StatusLoginKelurahan;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticatedKelurahan
{
  /**
   * Jika sudah login - baik sebagai akun kelurahan maupun sebagai admin
   * E-Panel - jangan tampilkan halaman login lagi.
   */
  public function handle(Request $request, Closure $next)
  {
    if (StatusLoginKelurahan::adaYangLogin()) {
      return redirect()->route('guest.hantu-banyu.index');
    }

    return $next($request);
  }
}
