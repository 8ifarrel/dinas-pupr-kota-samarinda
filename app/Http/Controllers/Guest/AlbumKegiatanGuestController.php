<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\AlbumKegiatan;
use App\Models\AlbumKegiatanView;
use App\Support\Shared\CatatViewUnik;
use Illuminate\Http\Request;

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

    CatatViewUnik::catat($request, AlbumKegiatanView::class, 'id_album_kegiatan', $album->id, $album);

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
}

