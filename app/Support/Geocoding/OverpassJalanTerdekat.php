<?php

namespace App\Support\Geocoding;

/**
 * Cari nama jalan besar terdekat via Overpass API (data OSM) ketika Nominatim
 * tidak punya nama jalan sama sekali, atau hanya punya nama gang di titik
 * tersebut.
 *
 * Diekstrak dari GeocodingController supaya logikanya bisa dipakai ulang
 * persis sama oleh HantuBanyuSeeder (seeder butuh nama jalan yang benar-benar
 * sinkron dengan koordinat, bukan sekadar tiruan terpisah yang bisa melenceng
 * dari perilaku fitur aslinya).
 */
class OverpassJalanTerdekat
{
  private const URUTAN_KELAS = [
    'primary' => 1,
    'secondary' => 2,
    'tertiary' => 3,
    'residential' => 4,
    'unclassified' => 5,
  ];

  /** Apakah panggilan Overpass terakhir gagal di tingkat jaringan/server. */
  private static bool $permintaanTerakhirGagal = false;

  /**
   * Bedakan "Overpass menolak/gagal dijangkau" dari "wilayah ini memang tidak
   * punya jalan bernama" - keduanya sama-sama menghasilkan daftar kosong.
   *
   * Penting untuk pemanggil yang mengulang permintaan (HantuBanyuSeeder):
   * tanpa ini, rentetan penolakan karena rate limit terbaca sebagai kesimpulan
   * "tidak ada jalan di sini" dan datanya jatuh ke cadangan tanpa nama jalan.
   */
  public static function permintaanTerakhirGagal(): bool
  {
    return self::$permintaanTerakhirGagal;
  }

  /** @return array{name:string,jarak:float,kelas:int}|null */
  public static function cari(float $lat, float $lon): ?array
  {
    foreach ([250, 600, 1200] as $radius) {
      $kandidat = self::jalanSekitar($lat, $lon, $radius);

      if ($kandidat !== []) {
        // Jarak fisik terdekat yang menang (mencerminkan jalan mana yang sebenarnya
        // menjadi akses/induk dari gang tersebut), kelas jalan hanya jadi filter di query.
        // jalanSekitar() sudah mengurutkan dari yang terdekat.
        $terbaik = $kandidat[0];

        return ['name' => $terbaik['name'], 'jarak' => $terbaik['jarak'], 'kelas' => $terbaik['kelas']];
      }
    }

    return null;
  }

  /**
   * Seluruh ruas jalan bernama di sekitar sebuah titik, lengkap dengan
   * geometri (daftar simpul lat/lon) tiap ruas, terurut dari yang terdekat.
   *
   * Dipakai cari() untuk mengambil yang terdekat saja, dan dipakai
   * HantuBanyuSeeder untuk hal sebaliknya: menempatkan titik-titik contoh
   * TEPAT di atas ruas jalan bernama, sehingga koordinat dan nama jalannya
   * pasti sinkron tanpa perlu menebak lewat reverse-geocode per titik.
   *
   * @return array<int,array{name:string,geometry:array<int,array{lat:float,lon:float}>,jarak:float,kelas:int}>
   */
  public static function jalanSekitar(float $lat, float $lon, int $radius): array
  {
    $jenisJalan = implode('|', array_keys(self::URUTAN_KELAS));

    return self::jalankanQuery(
      "[out:json][timeout:25];way(around:{$radius},{$lat},{$lon})[\"highway\"~\"^({$jenisJalan})$\"][\"name\"];out tags geom;",
      $lat,
      $lon
    );
  }

  /**
   * Seluruh ruas jalan bernama yang berada DI DALAM sebuah batas wilayah
   * administratif OSM (relation), bukan sekadar dalam radius tertentu.
   *
   * Dipakai HantuBanyuSeeder supaya titik contoh sebuah kelurahan dijamin
   * jatuh di dalam kelurahan itu sendiri - radius mengelilingi titik pusat
   * mau tidak mau ikut menjaring jalan milik kelurahan tetangga.
   *
   * @param int $osmRelationId id relation batas wilayah dari Nominatim
   * @return array<int,array{name:string,geometry:array<int,array{lat:float,lon:float}>,jarak:float,kelas:int}>
   */
  public static function jalanDalamArea(float $lat, float $lon, int $osmRelationId): array
  {
    $jenisJalan = implode('|', array_keys(self::URUTAN_KELAS));
    // Overpass menomori area sebuah relation sebagai 3600000000 + id relation.
    $areaId = 3600000000 + $osmRelationId;

    return self::jalankanQuery(
      "[out:json][timeout:25];area({$areaId})->.a;way(area.a)[\"highway\"~\"^({$jenisJalan})$\"][\"name\"];out tags geom;",
      $lat,
      $lon
    );
  }

  /**
   * Jalankan satu query Overpass dan ubah hasilnya jadi daftar ruas jalan
   * bernama, terurut dari yang terdekat ke titik acuan.
   *
   * @return array<int,array{name:string,geometry:array<int,array{lat:float,lon:float}>,jarak:float,kelas:int}>
   */
  private static function jalankanQuery(string $query, float $lat, float $lon): array
  {
    self::$permintaanTerakhirGagal = false;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, config('services.overpass.url'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['data' => $query]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'dinas-pupr-kota-samarinda/1.0');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode < 200 || $httpCode >= 300 || !$response) {
      self::$permintaanTerakhirGagal = true;

      return [];
    }

    $data = json_decode($response, true);

    // Overpass sering menjawab 200 tapi menolak mengerjakan query, dengan
    // alasannya ditaruh di field 'remark' (server sibuk, kehabisan memori,
    // batas waktu terlampaui). Itu kegagalan, bukan hasil kosong.
    if (!is_array($data) || isset($data['remark'])) {
      self::$permintaanTerakhirGagal = true;

      return [];
    }

    $elements = $data['elements'] ?? [];

    $hasil = [];
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

      $hasil[] = [
        'name' => $nama,
        'geometry' => $geometry,
        'jarak' => self::jarakKeGaris($lat, $lon, $geometry),
        'kelas' => self::URUTAN_KELAS[$way['tags']['highway']] ?? 99,
      ];
    }

    usort($hasil, fn($a, $b) => $a['jarak'] <=> $b['jarak']);

    return $hasil;
  }

  /** Jarak (meter, perkiraan equirectangular) dari sebuah titik ke garis polyline OSM. */
  private static function jarakKeGaris(float $lat, float $lon, array $geometry): float
  {
    $terkecil = null;

    for ($i = 0; $i < count($geometry) - 1; $i++) {
      $jarak = self::jarakKeSegmen(
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

  private static function jarakKeSegmen(float $lat, float $lon, float $lat1, float $lon1, float $lat2, float $lon2): float
  {
    // Proyeksi equirectangular sederhana (cukup akurat untuk jarak pendek dalam kota)
    $meterPerDerajatLat = 111320.0;
    $meterPerDerajatLon = 111320.0 * cos(deg2rad($lat));

    $toXY = function (float $la, float $lo) use ($meterPerDerajatLat, $meterPerDerajatLon) {
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
