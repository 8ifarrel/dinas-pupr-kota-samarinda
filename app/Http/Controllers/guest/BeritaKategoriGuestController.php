<?php

namespace App\Http\Controllers\guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BeritaKategori;
use App\Models\Berita;

class BeritaKategoriGuestController extends Controller
{
  public function index()
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_title = "Informasi PUPR";
    $page_subtitle = "Kategori Berita";

    $berita_kategori = BeritaKategori::with('jabatan')->select(
      'id_jabatan',
      'ikon_berita_kategori',
    )->get();

    return view('guest.pages.berita.kategori.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'berita_kategori' => $berita_kategori,
    ]);
  }

  public function show($slug_kategori)
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda";
    $page_title = "Informasi PUPR";
    $page_subtitle = "Berita dari " . str_replace('-', ' ', ucfirst($slug_kategori));

    $berita_kategori = BeritaKategori::whereHas('jabatan', function ($query) use ($slug_kategori) {
      $query->where('slug_jabatan', $slug_kategori);
    })->firstOrFail();

    $berita = Berita::with(['kategori', 'kategori.jabatan'])
      ->where('id_berita_kategori', $berita_kategori->id_berita_kategori)
      ->select('judul_berita', 'slug_berita', 'foto_berita', 'created_at', 'views_count')
      ->paginate(6);

    $berita_lainnya = Berita::select('judul_berita', 'slug_berita', 'foto_berita', 'created_at', 'views_count')
      ->limit(12)
      ->get();

    return view('guest.pages.berita.kategori.show', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'berita_kategori' => $berita_kategori,
      'berita' => $berita,
      'berita_lainnya' => $berita_lainnya,
      'slug_kategori' => $slug_kategori,
    ]);
  }

  public function search(Request $request, $slug_kategori)
  {
    $query = $request->input('query');

    $berita_kategori = BeritaKategori::whereHas('jabatan', function ($query) use ($slug_kategori) {
      $query->where('slug_jabatan', $slug_kategori);
    })->firstOrFail();

    $berita = Berita::where('id_berita_kategori', $berita_kategori->id_berita_kategori)
      ->where('judul_berita', 'LIKE', "%{$query}%")
      ->select('judul_berita', 'slug_berita', 'foto_berita', 'created_at', 'views_count')
      ->paginate(6);

    return response()->json([
      'data' => $berita->items(),
      'viewPagination' => $berita->appends(['query' => $query])->links()->render()
    ]);
  }
}
