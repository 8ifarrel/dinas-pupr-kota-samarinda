<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey; // Import model ApiKey

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKeyHeader = $request->header('X-API-KEY');

        if (empty($apiKeyHeader)) {
            return response()->json(['message' => 'Akses ditolak. X-API-KEY header tidak ditemukan.'], 401);
        }

        // Cari API key di database
        $apiKey = ApiKey::where('key', $apiKeyHeader)->where('is_active', true)->first();

        if (!$apiKey) {
            return response()->json(['message' => 'Akses ditolak. API Key tidak valid atau tidak aktif.'], 401);
        }

        // Jika valid, lanjutkan request
        return $next($request);
    }
}
    