<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\PPIDPelaksanaKategori;
use Illuminate\Http\Request;

class PPIDPelaksanaKategoriGuestController extends Controller
{
  public string $page_context = 'PPID Pelaksana';

  public function index()
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_title = "Kategori PPID Pelaksana";
    $page_subtitle = "Informasi PUPR";
    $ppid_pelaksana_katgori = PPIDPelaksanaKategori::withCount('ppid_pelaksana')->get();

    return view('guest.pages.ppid-pelaksana.kategori.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'ppid_pelaksana_kategori' => $ppid_pelaksana_katgori,
      'page_context' => $this->page_context,
    ]);
  }

  public function show($slug)
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Informasi PUPR";
    $ppid_pelaksana_kategori = PPIDPelaksanaKategori::where('slug', $slug)->firstOrFail();
    $page_title = "PPID Pelaksana " . $ppid_pelaksana_kategori->nama;
    $ppid_pelaksana = $ppid_pelaksana_kategori->ppid_pelaksana()->orderBy('created_at', 'desc');

    return view('guest.pages.ppid-pelaksana.kategori.show', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'ppid_pelaksana_kategori' => $ppid_pelaksana_kategori,
      'ppid_pelaksana' => $ppid_pelaksana,
      'page_context' => $this->page_context,
    ]);
  }
}
