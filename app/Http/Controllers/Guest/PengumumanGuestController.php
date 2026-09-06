<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\PengumumanView;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class PengumumanGuestController extends Controller
{
  public string $page_context = 'Pengumuman';

  public function index()
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Informasi PUPR";
    $page_title = "Pengumuman";

    $pengumuman = Pengumuman::select(
      "judul_pengumuman",
      "slug_pengumuman",
      "perihal",
      "file_lampiran",
      "created_at",
      'updated_at',
      "views_count",
    )->get();

    return view('guest.pages.pengumuman.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'pengumuman' => $pengumuman,
      'page_context' => $this->page_context,
    ]);
  }

  public function store(Request $request, $slug)
  {
    $pengumuman = Pengumuman::where('slug_pengumuman', $slug)->firstOrFail();

    $this->catatView($request, $pengumuman);

    return response()->json(['success' => true]);
  }

  /**
   * Menambah views_count paling banyak sekali per pengunjung per pengumuman.
   *
   * Mengikuti cara kerja statistik pengunjung: pengunjung dikenali lewat cookie
   * visitor_id yang sama, dan crawler tidak dihitung. Sebelumnya angka ini naik
   * setiap kali modal pengumuman dibuka, jadi satu orang yang membuka-tutup
   * modal yang sama sepuluh kali ikut menaikkannya sepuluh kali.
   *
   * Balasan endpoint ini tetap {"success": true} entah views bertambah atau
   * tidak, karena bagi pengunjung yang penting isi pengumumannya terbuka;
   * naik-tidaknya hitungan bukan urusan yang perlu dia tahu.
   */
  private function catatView(Request $request, Pengumuman $pengumuman): void
  {
    if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
      return;
    }

    $visitorId = $request->cookie('visitor_id');
    if (!is_string($visitorId) || $visitorId === '' || strlen($visitorId) > 64) {
      return;
    }

    $sudahPernah = PengumumanView::where('visitor_id', $visitorId)
      ->where('id_pengumuman', $pengumuman->id)
      ->exists();

    if ($sudahPernah) {
      return;
    }

    try {
      PengumumanView::create([
        'visitor_id' => $visitorId,
        'id_pengumuman' => $pengumuman->id,
        'viewed_at' => now(),
      ]);
    } catch (QueryException $e) {
      // Kena unique constraint: dua permintaan kembar datang nyaris bersamaan
      // dan yang satunya sudah lebih dulu mencatat. Cukup abaikan, jangan
      // menaikkan hitungan untuk kedua kalinya.
      return;
    }

    $pengumuman->increment('views_count');
  }

  public function download($slug)
  {
    $pengumuman = Pengumuman::where('slug_pengumuman', $slug)->firstOrFail();

    if (!$pengumuman->file_lampiran || !Storage::disk('public')->exists($pengumuman->file_lampiran)) {
      abort(404, 'File tidak ditemukan');
    }

    $filename = $pengumuman->judul_pengumuman . '.' . pathinfo($pengumuman->file_lampiran, PATHINFO_EXTENSION);

    return Storage::disk('public')->download($pengumuman->file_lampiran, $filename);
  }
}

