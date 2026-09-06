<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\BeritaView;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class BeritaGuestController extends Controller
{
  public string $page_context = 'Berita';

  public function show(Request $request, $slug_berita)
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_title = "Informasi PUPR";

    $berita = Berita::where('slug_berita', $slug_berita)->firstOrFail();

    $this->catatView($request, $berita);

    $berita_lainnya = Berita::select(
      'judul_berita',
      'slug_berita',
      'foto_berita',
      'created_at',
      'views_count'
    )->limit(5)->get();

    return view('guest.pages.berita.show', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'berita' => $berita,
      'berita_lainnya' => $berita_lainnya,
      'page_context' => $this->page_context,
    ]);
  }

  /**
   * Menambah views_count paling banyak sekali per pengunjung per berita.
   *
   * Mengikuti cara kerja statistik pengunjung: pengunjung dikenali lewat cookie
   * visitor_id yang sama, dan crawler tidak dihitung. Sebelumnya angka ini naik
   * pada setiap muat halaman, jadi satu orang yang menekan refresh sepuluh kali
   * ikut menaikkannya sepuluh kali.
   *
   * Pencatatan tidak boleh menggagalkan tampilnya halaman: kalau apa pun
   * bermasalah di sini, pembaca tetap harus bisa membaca beritanya.
   */
  private function catatView(Request $request, Berita $berita): void
  {
    if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
      return;
    }

    $visitorId = $request->cookie('visitor_id');
    if (!is_string($visitorId) || $visitorId === '' || strlen($visitorId) > 64) {
      return;
    }

    $sudahPernah = BeritaView::where('visitor_id', $visitorId)
      ->where('uuid_berita', $berita->uuid_berita)
      ->exists();

    if ($sudahPernah) {
      return;
    }

    try {
      BeritaView::create([
        'visitor_id' => $visitorId,
        'uuid_berita' => $berita->uuid_berita,
        'viewed_at' => now(),
      ]);
    } catch (QueryException $e) {
      // Kena unique constraint: dua permintaan kembar datang nyaris bersamaan
      // dan yang satunya sudah lebih dulu mencatat. Cukup abaikan, jangan
      // menaikkan hitungan untuk kedua kalinya.
      return;
    }

    $berita->increment('views_count');
  }
}
