<?php

namespace App\Support\Shared;

use Illuminate\Support\Facades\Auth;

/**
 * Guard 'kelurahan' dan guard 'web' (akun admin E-Panel) berbagi session
 * yang sama, sehingga "sudah login" berarti salah satu dari keduanya aktif.
 */
class StatusLoginKelurahan
{
  /** @return bool true bila akun kelurahan ATAU akun admin E-Panel sedang login pada session ini. */
  public static function adaYangLogin(): bool
  {
    return Auth::guard('kelurahan')->check() || Auth::guard('web')->check();
  }
}
