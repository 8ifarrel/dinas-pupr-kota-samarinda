<?php

/**
 * Server Nominatim + Overpass palsu untuk test Hantu Banyu (dijalankan lewat
 * `php -S`). Jawabannya tetap per koordinat, dan setiap permintaan dicatat
 * ke berkas HB_GEO_LOG supaya test bisa menghitung panggilan eksternal.
 *
 * Skenario per latitude:
 *   -0.4600000  ada nama jalan & kelurahan Air Putih
 *   -0.4650000  kelurahan Sidodadi (di luar Air Putih)
 *   -0.4700000  tanpa nama jalan -> Overpass radius 250 menemukan jalan
 *   -0.4800000  nama gang -> Overpass 250 kosong, 600 menemukan jalan
 *   -0.4900000  tanpa nama jalan -> Overpass semua radius kosong
 *   -0.5000000  Nominatim galat 500
 *   -0.5100000  tanpa nama jalan -> Overpass 250 menolak (remark), 600 menemukan
 *   -0.5200000  hanya kecamatan (tanpa village), Samarinda Ulu
 */

$log = getenv('HB_GEO_LOG');
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$body = file_get_contents('php://input');

if ($path === '/reverse') {
  $lat = sprintf('%.7f', (float) ($_GET['lat'] ?? 0));
  file_put_contents($log, "nominatim lat={$lat} lang=" . ($_GET['accept-language'] ?? '-') . "\n", FILE_APPEND);

  $alamat = [
    '-0.4600000' => ['road' => 'Jalan Pahlawan', 'village' => 'Air Putih', 'city_district' => 'Samarinda Ulu', 'city' => 'Samarinda'],
    '-0.4650000' => ['road' => 'Jalan Juanda', 'village' => 'Sidodadi', 'city_district' => 'Samarinda Ulu', 'city' => 'Samarinda'],
    '-0.4700000' => ['village' => 'Air Putih', 'city_district' => 'Samarinda Ulu', 'city' => 'Samarinda'],
    '-0.4800000' => ['road' => 'Gg. Mawar', 'village' => 'Air Putih', 'city_district' => 'Samarinda Ulu'],
    '-0.4900000' => ['village' => 'Air Putih', 'city_district' => 'Samarinda Ulu'],
    '-0.5100000' => ['village' => 'Air Putih', 'city_district' => 'Samarinda Ulu'],
    '-0.5200000' => ['city_district' => 'Samarinda Ulu', 'city' => 'Samarinda'],
  ];

  if ($lat === '-0.5000000') {
    http_response_code(500);
    echo 'server error';
    return true;
  }

  header('Content-Type: application/json');
  echo json_encode([
    'place_id' => 1000 + (int) abs((float) $lat * 10000),
    'lat' => $lat,
    'lon' => $_GET['lon'] ?? null,
    'display_name' => 'Titik uji ' . $lat,
    'address' => $alamat[$lat] ?? ['city' => 'Samarinda'],
  ]);
  return true;
}

if ($path === '/interpreter') {
  parse_str($body, $form);
  $q = $form['data'] ?? $body;
  preg_match('/around:(\d+),([-\d.]+),([-\d.]+)/', $q, $m);
  $radius = (int) ($m[1] ?? 0);
  $lat = sprintf('%.7f', (float) ($m[2] ?? 0));
  $lon = (float) ($m[3] ?? 0);
  file_put_contents($log, "overpass radius={$radius} lat={$lat}\n", FILE_APPEND);

  $jalan = fn(string $nama, string $kelas, float $geser) => [
    'type' => 'way',
    'tags' => ['highway' => $kelas, 'name' => $nama],
    'geometry' => [
      ['lat' => (float) $lat + $geser, 'lon' => $lon - 0.001],
      ['lat' => (float) $lat + $geser, 'lon' => $lon + 0.001],
    ],
  ];

  $elemen = [];
  if ($lat === '-0.4700000' && $radius === 250) {
    $elemen = [$jalan('Gang Kenari', 'residential', 0.0003), $jalan('Jalan Siradj Salman', 'secondary', 0.0009), $jalan('Jalan Antasari', 'primary', 0.0015)];
  } elseif ($lat === '-0.4800000' && $radius === 600) {
    $elemen = [$jalan('Jalan Pramuka', 'tertiary', 0.004)];
  } elseif ($lat === '-0.5100000' && $radius === 250) {
    header('Content-Type: application/json');
    echo json_encode(['remark' => 'runtime error: Query timed out', 'elements' => []]);
    return true;
  } elseif ($lat === '-0.5100000' && $radius === 600) {
    $elemen = [$jalan('Jalan Merdeka', 'secondary', 0.003)];
  }

  header('Content-Type: application/json');
  echo json_encode(['version' => 0.6, 'elements' => $elemen]);
  return true;
}

http_response_code(404);
return true;
