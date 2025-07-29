<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SedotTinjaGuestController extends Controller
{
  // TODO: kirimkan variable ini ke view yang ada
  public string $page_context = 'Sedot Tinja';

  /**
   * Menampilkan halaman utama dan statistik laporan Sedot Tinja.
   */
  public function index()
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_title = "Sedot Tinja";

    // TODO: Ambil semua data Sedot Tinja dari database dan kirimkan ke view
  }

  /**
   * Menampilkan daftar laporan dan statistik laporan Sedot Tinja.
   */
  public function show()
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_title = "Lihat Laporan Sedot Tinja";

    // TODO: Ambil semua data Sedot Tinja dari database dan kirimkan ke view
  }

  /**
   * Menampilkan form untuk membuat laporan Sedot Tinja.
   */
  public function create()
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_title = "Lihat Laporan Sedot Tinja";

    // TODO: Tampilkan form untuk input data laporan Sedot Tinja
  }

  /**
   * Menyimpan data form laporan Sedot Tinja
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    // TODO: Validasi data yang dikirim dari form
    // TODO: Simpan data baru ke database
    // TODO: Redirect dan berikan response setelah penyimpanan
  }

}
