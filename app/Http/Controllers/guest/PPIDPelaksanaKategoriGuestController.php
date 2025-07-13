<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\PPIDPelaksanaKategori;
use Illuminate\Http\Request;

class PPIDPelaksanaKategoriGuestController extends Controller
{
  public function index()
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Kategori PPID Pelaksana";
    $page_title = "Informasi PUPR";
    $ppid_pelaksana_katgori = PPIDPelaksanaKategori::withCount('ppid_pelaksana')->get();

    return view('guest.pages.ppid-pelaksana.kategori.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'ppid_pelaksana_kategori' => $ppid_pelaksana_katgori,
    ]);
  }

  public function show($slug)
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_title = "Informasi PUPR";
    $page_subtitle = "PPID Pelaksana";
    $ppid_pelaksana_kategori = PPIDPelaksanaKategori::where('slug', $slug)->firstOrFail();
    $ppid_pelaksana = $ppid_pelaksana_kategori->ppid_pelaksana()->orderBy('created_at', 'desc');

    return view('guest.pages.ppid-pelaksana.kategori.show', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'ppid_pelaksana_kategori' => $ppid_pelaksana_kategori,
      'ppid_pelaksana' => $ppid_pelaksana,
    ]);
  }
}
