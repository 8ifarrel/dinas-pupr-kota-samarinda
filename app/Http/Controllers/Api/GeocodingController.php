<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$lat}&lon={$lon}&addressdetails=1";

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
     * tidak punya nama jalan sama sekali, atau hanya punya nama gang di titik tersebut.
     */
    private function cariJalanTerdekat(float $lat, float $lon): ?array
    {
        $urutanKelas = [
            'primary' => 1,
            'secondary' => 2,
            'tertiary' => 3,
            'residential' => 4,
            'unclassified' => 5,
        ];
        $jenisJalan = implode('|', array_keys($urutanKelas));

        foreach ([250, 600, 1200] as $radius) {
            $query = "[out:json][timeout:10];way(around:{$radius},{$lat},{$lon})[\"highway\"~\"^({$jenisJalan})$\"][\"name\"];out tags geom;";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://overpass-api.de/api/interpreter');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['data' => $query]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'dinas-pupr-kota-samarinda/1.0');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode < 200 || $httpCode >= 300 || !$response) {
                continue;
            }

            $data = json_decode($response, true);
            $elements = $data['elements'] ?? [];

            if (empty($elements)) {
                continue;
            }

            $terbaik = null;
            foreach ($elements as $way) {
                $nama = $way['tags']['name'] ?? null;
                $geometry = $way['geometry'] ?? [];
                if (!$nama || empty($geometry)) {
                    continue;
                }

                // Lewati kandidat yang namanya sendiri masih gang/blok -> bukan jalan induk sungguhan
                if (preg_match('/^(gg\.?|gang|blok)\b/i', trim($nama))) {
                    continue;
                }

                $jarak = $this->jarakKeGaris($lat, $lon, $geometry);
                $kelas = $urutanKelas[$way['tags']['highway']] ?? 99;

                // Jarak fisik terdekat yang menang (mencerminkan jalan mana yang sebenarnya
                // menjadi akses/induk dari gang tersebut), kelas jalan hanya jadi filter di query.
                if ($terbaik === null || $jarak < $terbaik['jarak']) {
                    $terbaik = ['name' => $nama, 'jarak' => $jarak, 'kelas' => $kelas];
                }
            }

            if ($terbaik) {
                return $terbaik;
            }
        }

        return null;
    }

    /**
     * Jarak (meter, perkiraan equirectangular) dari sebuah titik ke garis polyline OSM.
     */
    private function jarakKeGaris(float $lat, float $lon, array $geometry): float
    {
        $terkecil = null;

        for ($i = 0; $i < count($geometry) - 1; $i++) {
            $jarak = $this->jarakKeSegmen(
                $lat,
                $lon,
                $geometry[$i]['lat'],
                $geometry[$i]['lon'],
                $geometry[$i + 1]['lat'],
                $geometry[$i + 1]['lon']
            );

            if ($terkecil === null || $jarak < $terkecil) {
                $terkecil = $jarak;
            }
        }

        return $terkecil ?? PHP_FLOAT_MAX;
    }

    private function jarakKeSegmen(float $lat, float $lon, float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        // Proyeksi equirectangular sederhana (cukup akurat untuk jarak pendek dalam kota)
        $meterPerDerajatLat = 111320.0;
        $meterPerDerajatLon = 111320.0 * cos(deg2rad($lat));

        $toXY = function (float $la, float $lo) use ($lat, $meterPerDerajatLat, $meterPerDerajatLon) {
            return [$lo * $meterPerDerajatLon, $la * $meterPerDerajatLat];
        };

        [$px, $py] = $toXY($lat, $lon);
        [$ax, $ay] = $toXY($lat1, $lon1);
        [$bx, $by] = $toXY($lat2, $lon2);

        $dx = $bx - $ax;
        $dy = $by - $ay;

        if ($dx === 0.0 && $dy === 0.0) {
            return sqrt(($px - $ax) ** 2 + ($py - $ay) ** 2);
        }

        $t = (($px - $ax) * $dx + ($py - $ay) * $dy) / ($dx * $dx + $dy * $dy);
        $t = max(0, min(1, $t));

        $cx = $ax + $t * $dx;
        $cy = $ay + $t * $dy;

        return sqrt(($px - $cx) ** 2 + ($py - $cy) ** 2);
    }
}
