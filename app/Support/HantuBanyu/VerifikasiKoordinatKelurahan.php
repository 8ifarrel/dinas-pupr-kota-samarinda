<?php

namespace App\Support\HantuBanyu;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Verifikasi bahwa titik koordinat yang dikirim pelapor benar-benar berada
 * di kelurahan yang dilaporkan, lewat reverse-geocode ke Nominatim.
 */
class VerifikasiKoordinatKelurahan
{
  /**
   * Apakah koordinat berada di dalam kelurahan tersebut?
   *
   * @return bool|null true/false bila terverifikasi; null bila geocoder tidak
   *                   dapat dihubungi, sehingga pemanggil bisa membedakan
   *                   "lokasi salah" dari "belum bisa diperiksa".
   */
  public static function koordinatDiKelurahan($lat, $lon, string $namaKelurahan, string $namaKecamatan = ''): ?bool
  {
    $alamat = self::reverseGeocode($lat, $lon);

    if ($alamat === null) {
      return null;
    }

    $kelurahanGeo = $alamat['village'] ?? $alamat['neighbourhood'] ?? $alamat['hamlet'] ?? '';
    $kecamatanGeo = $alamat['city_district'] ?? $alamat['municipality'] ?? $alamat['county'] ?? $alamat['suburb'] ?? '';

    if ($kelurahanGeo !== '') {
      return self::namaCocok($kelurahanGeo, $namaKelurahan);
    }

    if ($kecamatanGeo !== '') {
      return self::namaCocok($kecamatanGeo, $namaKecamatan);
    }

    return false;
  }

  /**
   * Reverse-geocode koordinat menjadi array "address" dari Nominatim,
   * atau null bila gagal.
   */
  private static function reverseGeocode($lat, $lon): ?array
  {
    try {
      $res = Http::withHeaders([
        'User-Agent' => 'dinas-pupr-kota-samarinda/1.0 (hantu-banyu)',
      ])->timeout(8)->get(rtrim(config('services.nominatim.base_url'), '/') . '/reverse', [
        'format' => 'jsonv2',
        'lat' => $lat,
        'lon' => $lon,
        'addressdetails' => 1,
        'accept-language' => 'id',
      ]);

      if (!$res->ok()) {
        return null;
      }

      $alamat = $res->json('address');

      return is_array($alamat) ? $alamat : null;
    } catch (\Throwable $e) {
      Log::warning('Hantu Banyu reverse-geocode gagal: ' . $e->getMessage());

      return null;
    }
  }

  /**
   * Bandingkan nama wilayah dari geocoder dengan nama wilayah di basis data.
   * Toleran terhadap variasi penulisan (mis. "Sei/Sungai Dama",
   * "Simpang Tiga (Loa Janan Ilir)").
   */
  private static function namaCocok(string $dariGeocoder, string $dariDb): bool
  {
    if ($dariGeocoder === '' || $dariDb === '') {
      return false;
    }

    $a = self::variasiNama($dariGeocoder);
    $b = self::variasiNama($dariDb);

    foreach ($a as $x) {
      foreach ($b as $y) {
        if ($x === $y) {
          return true;
        }
        if (strlen($x) >= 4 && strlen($y) >= 4 && (str_contains($x, $y) || str_contains($y, $x))) {
          return true;
        }
      }
    }

    return false;
  }

  /**
   * Pecah sebuah nama wilayah menjadi beberapa varian ternormalisasi
   * (huruf kecil, tanpa spasi/tanda baca, "sei" -> "sungai").
   *
   * @return array<int,string>
   */
  private static function variasiNama(string $nama): array
  {
    $nama = strtolower(trim($nama));
    $potongan = preg_split('/[\/()]+/', $nama) ?: [];
    $potongan[] = $nama;

    $hasil = [];
    foreach ($potongan as $p) {
      $p = trim($p);
      $p = preg_replace('/\bsei\b/', 'sungai', $p);
      $p = preg_replace('/^(kelurahan|desa|kecamatan)\s+/', '', $p);
      $p = preg_replace('/[^a-z0-9]+/', '', $p);
      if ($p !== '') {
        $hasil[$p] = true;
      }
    }

    return array_keys($hasil);
  }
}
