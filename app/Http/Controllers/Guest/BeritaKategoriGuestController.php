<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BeritaKategori;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaKategoriGuestController extends Controller
{
  public string $page_context = 'Berita';

  public function index()
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Informasi PUPR";
    $page_title = "Kategori Berita";

    $berita_kategori = BeritaKategori::with('susunanOrganisasi')
      ->select('id_berita_kategori', 'id_susunan_organisasi', 'ikon_berita_kategori')
      ->get()
      ->map(function ($kategori) {
        $kategori->jumlah_berita_count = Berita::where('id_berita_kategori', $kategori->id_berita_kategori)->count();
        $kategori->jumlah_views_count = Berita::where('id_berita_kategori', $kategori->id_berita_kategori)->sum('views_count');
        return $kategori;
      });

    return view('guest.pages.berita.kategori.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'berita_kategori' => $berita_kategori,
      'page_context' => $this->page_context,
    ]);
  }

  public function show($slug_kategori)
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda";
    $page_subtitle = "Informasi PUPR";

    $berita_kategori = BeritaKategori::whereHas('susunanOrganisasi', function ($query) use ($slug_kategori) {
      $query->where('slug_susunan_organisasi', $slug_kategori);
    })->firstOrFail();

    $page_title = "Berita dari " . $berita_kategori->susunanOrganisasi->nama_susunan_organisasi;

    $berita = Berita::with(['kategori', 'kategori.jabatan'])
      ->where('id_berita_kategori', $berita_kategori->id_berita_kategori)
      ->select(
        'judul_berita',
        'slug_berita',
        'foto_berita',
        'created_at',
        'views_count'
      )->paginate(8);

    $berita_lainnya = Berita::select(
      'judul_berita',
      'slug_berita',
      'foto_berita',
      'created_at',
      'views_count'
    )->limit(12)->get();

    return view('guest.pages.berita.kategori.show', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'berita_kategori' => $berita_kategori,
      'berita' => $berita,
      'berita_lainnya' => $berita_lainnya,
      'slug_kategori' => $slug_kategori,
      'page_context' => $this->page_context,
    ]);
  }

  public function search(Request $request, $slug_kategori)
  {
    $query = $request->input('query');

    $berita_kategori = BeritaKategori::whereHas('susunanOrganisasi', function ($query) use ($slug_kategori) {
      $query->where('slug_susunan_organisasi', $slug_kategori);
    })->firstOrFail();

    $berita = Berita::where('id_berita_kategori', $berita_kategori->id_berita_kategori)
      ->where('judul_berita', 'LIKE', "%{$query}%")
      ->select(
        'judul_berita',
        'slug_berita',
        'foto_berita',
        'created_at',
        'views_count'
      )->paginate(6);

    $berita->getCollection()->transform(function ($item) {
      $item->foto_berita = Storage::url($item->foto_berita);
      return $item;
    });

    return response()->json([
      'data' => $berita->items(),
      'viewPagination' => $berita->appends(['query' => $query])->links()->render()
    ]);
  }
}

