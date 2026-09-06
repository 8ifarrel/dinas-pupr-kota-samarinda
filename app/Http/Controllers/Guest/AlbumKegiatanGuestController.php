<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\AlbumKegiatan;
use App\Models\AlbumKegiatanView;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class AlbumKegiatanGuestController extends Controller
{
  public string $page_context = 'Album Kegiatan';

  public function index()
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Informasi PUPR";
    $page_title = "Album Kegiatan";

    $album_kegiatan = AlbumKegiatan::with(['fotoKegiatan' => function($q) {
      $q->orderBy('created_at', 'asc');
    }])->get();

    return view('guest.pages.album-kegiatan.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'album_kegiatan' => $album_kegiatan,
      'page_context' => $this->page_context,
    ]);
  }

  public function show(Request $request, $slug)
  {
    $album = AlbumKegiatan::where('slug', $slug)
      ->with('fotoKegiatan')
      ->firstOrFail();

    $this->catatView($request, $album);

    $meta_description = "Lihat foto-foto kegiatan pada album: " . $album->judul;
    $page_subtitle = "Informasi PUPR";
    $page_title = "Album Kegiatan " . $album->judul;

    return view('guest.pages.album-kegiatan.show', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'album' => $album,
      'photos' => $album->fotoKegiatan,
      'page_context' => $this->page_context,
    ]);
  }

  /**
   * Menambah views_count paling banyak sekali per pengunjung per album.
   *
   * Mengikuti cara kerja statistik pengunjung: pengunjung dikenali lewat cookie
   * visitor_id yang sama, dan crawler tidak dihitung. Sebelumnya angka ini naik
   * pada setiap muat halaman, jadi satu orang yang menekan refresh sepuluh kali
   * ikut menaikkannya sepuluh kali.
   *
   * Pencatatan tidak boleh menggagalkan tampilnya halaman: kalau apa pun
   * bermasalah di sini, pengunjung tetap harus bisa melihat foto-fotonya.
   */
  private function catatView(Request $request, AlbumKegiatan $album): void
  {
    if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
      return;
    }

    $visitorId = $request->cookie('visitor_id');
    if (!is_string($visitorId) || $visitorId === '' || strlen($visitorId) > 64) {
      return;
    }

    $sudahPernah = AlbumKegiatanView::where('visitor_id', $visitorId)
      ->where('id_album_kegiatan', $album->id)
      ->exists();

    if ($sudahPernah) {
      return;
    }

    try {
      AlbumKegiatanView::create([
        'visitor_id' => $visitorId,
        'id_album_kegiatan' => $album->id,
        'viewed_at' => now(),
      ]);
    } catch (QueryException $e) {
      // Kena unique constraint: dua permintaan kembar datang nyaris bersamaan
      // dan yang satunya sudah lebih dulu mencatat. Cukup abaikan, jangan
      // menaikkan hitungan untuk kedua kalinya.
      return;
    }

    $album->increment('views_count');
  }
}

