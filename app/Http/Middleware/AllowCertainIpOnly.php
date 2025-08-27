<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowCertainIpOnly
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next)
  {
    $allowedIps = config('app.allowed_ips');

    if (!in_array($request->ip(), $allowedIps)) {
      abort(403, 'Akses ditolak');
    }

    return $next($request);
  }
}
