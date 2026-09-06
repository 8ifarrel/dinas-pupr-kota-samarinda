<?php

namespace App\Http\Middleware;

use App\Models\HantuBanyuApiKey;
use App\Models\JalanPeduliApiKey;
use App\Models\KelurahanApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
  /** @var array<string, class-string<\App\Models\BaseApiKey>> */
  protected array $models = [
    'jalan-peduli' => JalanPeduliApiKey::class,
    'hantu-banyu' => HantuBanyuApiKey::class,
    'akun-kelurahan' => KelurahanApiKey::class,
  ];

  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   * @param  string  $layanan  fitur pemilik kunci, mis. "jalan-peduli" (default) atau "hantu-banyu"
   */
  public function handle(Request $request, Closure $next, string $layanan = 'jalan-peduli'): Response
  {
    $apiKeyHeader = $request->header('X-API-KEY');

    if (empty($apiKeyHeader)) {
      return response()->json(['message' => 'Akses ditolak. X-API-KEY header tidak ditemukan.'], 401);
    }

    $model = $this->models[$layanan] ?? JalanPeduliApiKey::class;

    // Cari API key di database
    $apiKey = $model::where('key', $apiKeyHeader)->where('is_active', true)->first();

    if (!$apiKey) {
      return response()->json(['message' => 'Akses ditolak. API Key tidak valid atau tidak aktif.'], 401);
    }

    // Jika valid, lanjutkan request
    return $next($request);
  }
}
