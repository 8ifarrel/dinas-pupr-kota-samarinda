<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\Geocoding\OverpassJalanTerdekat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeocodingController extends Controller
{
  public function reverseGeocode(Request $request)
  {
    $lat = $request->query('lat');
    $lon = $request->query('lon');

    if (!$lat || !$lon) {
      return response()->json(['error' => 'Missing latitude or longitude parameters'], 400);
    }

    try {
      $baseUrl = rtrim(config('services.nominatim.base_url'), '/');
      $url = "{$baseUrl}/reverse?format=jsonv2&lat={$lat}&lon={$lon}&addressdetails=1";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_USERAGENT, 'dinas-pupr-kota-samarinda/1.0');
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);

      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlError = curl_error($ch);
      curl_close($ch);

      if ($curlError) {
        Log::error("cURL Error: " . $curlError);
        return response()->json(['error' => 'Failed to connect to geocoding service'], 500);
      }

      if ($httpCode < 200 || $httpCode >= 300) {
        Log::error("HTTP Error: Status $httpCode, Response: $response");
        return response()->json(['error' => 'Failed to get geocoding data', 'status' => $httpCode], 500);
      }

      $result = json_decode($response, true) ?: [];

      $road = $result['address']['road'] ?? null;
      $butuhFallback = !$road || preg_match('/^(gg\.?|gang|blok)\b/i', trim($road));

      if ($butuhFallback) {
        $jalanTerdekat = $this->cariJalanTerdekat((float) $lat, (float) $lon);

        if ($jalanTerdekat) {
          if ($road) {
            // Gabungkan jalan induk + nama gang/blok aslinya, mis. "Jalan Haji Bakran, Blok E"
            $result['address']['road_asli'] = $road;
            $result['address']['road'] = $jalanTerdekat['name'] . ', ' . $road;
          } else {
            $result['address']['road'] = $jalanTerdekat['name'];
          }
          $result['road_perkiraan'] = true;
        }
      }

      return response()->json($result);
    } catch (\Exception $e) {
      Log::error('Geocoding Error: ' . $e->getMessage());
      return response()->json(['error' => 'Failed to get geocoding data: ' . $e->getMessage()], 500);
    }
  }

  /**
   * Cari nama jalan besar terdekat via Overpass API (data OSM) ketika Nominatim
   * tidak punya nama jalan sama sekali, atau hanya punya nama gang di titik
   * tersebut. Logikanya ada di OverpassJalanTerdekat supaya bisa dipakai ulang
   * persis sama oleh HantuBanyuSeeder.
   */
  private function cariJalanTerdekat(float $lat, float $lon): ?array
  {
    return OverpassJalanTerdekat::cari($lat, $lon);
  }
}
