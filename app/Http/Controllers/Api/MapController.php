<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    public function getCoordinates(Request $request)
    {
        $request->validate([
            'map_url' => 'required|url',
        ]);

        $shareUrl = $request->input('map_url');

        try {
            $response = Http::timeout(15)
                           ->withoutVerifying()
                           ->get($shareUrl);

            if (!$response->successful()) {
                Log::error("Gagal mengambil URL berbagi: {$shareUrl} - Status: " . $response->status());
                return response()->json(['error' => 'Tidak dapat menyelesaikan tautan berbagi. Status HTTP: ' . $response->status()], 400);
            }

            $finalUrl = (string) $response->effectiveUri();

            if (!$finalUrl) {
                Log::warning("URL berbagi {$shareUrl} tidak dapat diselesaikan ke URL akhir.");
                return response()->json(['error' => 'Tidak dapat menyelesaikan tautan berbagi ke URL akhir.'], 400);
            }

            $latitude = null;
            $longitude = null;

            // Prioritas 1: Mencari pola data=!3dLAT!4dLNG
            if (preg_match('/data=.*!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $finalUrl, $matchesData)) {
                $latitude = (float) $matchesData[1];
                $longitude = (float) $matchesData[2];
            }

            // Prioritas 2 (Cadangan): Mencari pola @latitude,longitude
            if (is_null($latitude) || is_null($longitude)) {
                if (preg_match('/search\/(-?\d+\.\d+)\s*,\s*\+(-?\d+\.\d+)/', $finalUrl, $matchesSearch)) {
                    $latitude = (float) $matchesSearch[1];
                    $longitude = (float) $matchesSearch[2];
                }
            }
            
            // Prioritas 3 (Cadangan): Parameter 'll' di query string
            if (is_null($latitude) || is_null($longitude)) {
                $parsedUrl = parse_url($finalUrl);
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $queryParams);
                    if (isset($queryParams['ll'])) {
                        $llParts = explode(',', $queryParams['ll']);
                        if (count($llParts) === 2 && is_numeric($llParts[0]) && is_numeric($llParts[1])) {
                            $latitude = (float) $llParts[0];
                            $longitude = (float) $llParts[1];
                        }
                    }
                }
            }

            if (!is_null($latitude) && !is_null($longitude)) {
                return response()->json([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'sumber_pola' => isset($matchesData[0]) ? 'data_param' : (isset($matchesAt[0]) ? 'at_param' : (isset($queryParams['ll']) ? 'll_param' : 'tidak_diketahui')),
                    'url_akhir' => $finalUrl,
                ]);
            } else {
                Log::warning("Link Anda Tidak Valid, Titik Koordinat Tidak Ditemukan: {$finalUrl} (Asli: {$shareUrl})");
                return response()->json([
                    'error' => 'Link Anda Tidak Valid, Titik Koordinat Tidak Ditemukan.',
                    'url_akhir' => $finalUrl,
                ], 400);
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("Kesalahan Koneksi saat mengambil URL peta {$shareUrl}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal terhubung ke layanan peta. Silakan periksa jaringan Anda.'], 500);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error("Kesalahan Permintaan saat mengambil URL peta {$shareUrl}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil URL peta: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error("Kesalahan umum saat memproses URL peta {$shareUrl}: " . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan tak terduga: ' . $e->getMessage()], 500);
        }
    }
}