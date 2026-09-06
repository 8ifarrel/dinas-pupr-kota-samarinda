<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
  public function handle(Request $request, Closure $next)
  {
    // Anotasi diperlukan karena guard mengembalikan kontrak Authenticatable,
    // sedangkan model sebenarnya baru ditentukan config/auth.php saat berjalan.
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user || !$user->is_super_admin) {
      abort(403, 'Unauthorized');
    }
    return $next($request);
  }
}

