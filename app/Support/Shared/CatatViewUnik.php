<?php

namespace App\Support\Shared;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

/**
 * Menambah views_count paling banyak sekali per pengunjung per konten.
 *
 * Pengunjung dikenali lewat cookie visitor_id; crawler tidak dihitung.
 * Tanpa pembatasan ini, angka bisa naik pada setiap muat halaman, jadi satu
 * orang yang menekan refresh berkali-kali ikut menaikkannya berkali-kali.
 *
 * Aman dipanggil dari mana pun yang menampilkan konten ke publik: kegagalan
 * di dalam fungsi ini tidak pernah melempar exception ke pemanggil, supaya
 * pengunjung tetap bisa melihat kontennya.
 */
class CatatViewUnik
{
  /**
   * @param  class-string<Model>  $kelasView  model log view (mis. BeritaView::class)
   * @param  string  $kolomKunci              nama kolom FK di $kelasView yang
   *                                          menunjuk ke $konten (mis. 'uuid_berita')
   * @param  mixed  $nilaiKunci               nilai kunci konten (mis. $berita->uuid_berita)
   * @param  Model  $konten                   record konten yang dilihat, punya
   *                                          kolom views_count untuk dinaikkan
   */
  public static function catat(Request $request, string $kelasView, string $kolomKunci, $nilaiKunci, Model $konten): void
  {
    if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
      return;
    }

    $visitorId = $request->cookie('visitor_id');
    if (!is_string($visitorId) || $visitorId === '' || strlen($visitorId) > 64) {
      return;
    }

    $sudahPernah = $kelasView::where('visitor_id', $visitorId)
      ->where($kolomKunci, $nilaiKunci)
      ->exists();

    if ($sudahPernah) {
      return;
    }

    try {
      $kelasView::create([
        'visitor_id' => $visitorId,
        $kolomKunci => $nilaiKunci,
        'viewed_at' => now(),
      ]);
    } catch (QueryException $e) {
      // Kena unique constraint: dua permintaan kembar datang nyaris bersamaan
      // dan yang satunya sudah lebih dulu mencatat. Cukup abaikan, jangan
      // menaikkan hitungan untuk kedua kalinya.
      return;
    }

    $konten->increment('views_count');
  }
}
