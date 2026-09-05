<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ValidateSignedAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only allow access if the URL is signed and valid
        if ($request->hasValidSignature()) {
            return $next($request);
        }
        
        // Access denied
        abort(403, 'Token tidak valid atau sudah kadaluarsa');
    }
}
