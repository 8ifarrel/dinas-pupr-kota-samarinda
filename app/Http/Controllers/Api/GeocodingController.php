<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            // Check if Guzzle is installed
            if (!class_exists('GuzzleHttp\Client')) {
                Log::error('Guzzle HTTP client is not installed');
                return response()->json(['error' => 'HTTP client not available'], 500);
            }
            
            // Use direct cURL as a fallback in case Http facade has issues
            $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$lat}&lon={$lon}";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'dinas-pupr-kota-samarinda/1.0');
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($curlError) {
                Log::error("cURL Error: " . $curlError);
                return response()->json(['error' => 'Failed to connect to geocoding service'], 500);
            }
            
            if ($httpCode >= 200 && $httpCode < 300) {
                return response()->json(json_decode($response, true));
            } else {
                Log::error("HTTP Error: Status $httpCode, Response: $response");
                return response()->json(['error' => 'Failed to get geocoding data', 'status' => $httpCode], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Geocoding Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get geocoding data: ' . $e->getMessage()], 500);
        }
    }
}
