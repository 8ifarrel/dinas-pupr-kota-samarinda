<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\UserKelurahan;
use App\Support\HantuBanyu\OtorisasiPengelola;
use App\Support\HantuBanyu\StatistikLaporan;
use Illuminate\Support\Facades\Auth;

/**
 * Statistik laporan Hantu Banyu untuk halaman publik.
 *
 * Setiap akun kelurahan hanya melihat statistik laporan di kelurahannya.
 */
class HantuBanyuGuestController extends Controller
{
  public string $page_context = 'Hantu Banyu';

  /** Instance dibuat sekali per siklus request, supaya query unit pemilik tidak dijalankan dua kali. */
  private ?OtorisasiPengelola $otorisasi = null;

  private function otorisasi(): OtorisasiPengelola
  {
    return $this->otorisasi ??= new OtorisasiPengelola();
  }

  public function index()
  {
    $akun = $this->akunKelurahan();
    $kelurahanId = optional($akun)->kelurahan_id;

    // Akun kelurahan melihat statistik wilayahnya sendiri; admin UPTD
    // melihat statistik seluruh kota, sama persis dengan yang di E-Panel.
    $adalahAdmin = !$akun && Auth::guard('web')->check();

    return view('guest.pages.hantu-banyu.index', array_merge(
      StatistikLaporan::compute($kelurahanId),
      [
        'meta_description' => 'Laporkan masalah banjir dan kerusakan saluran drainase dan irigasi melalui layanan Hantu Banyu Dinas PUPR Kota Samarinda.',
        'page_title' => 'Hantu Banyu',
        'page_subtitle' => 'Layanan Umum',
        'page_context' => $this->page_context,

        // Penanda wilayah yang sedang dilihat, mis. "Kelurahan Air Putih".
        'statistik_subjudul' => $akun
          ? 'Kelurahan ' . (optional($akun->kelurahan)->nama ?? '-')
          : 'Seluruh Kelurahan Kota Samarinda',

        // Sebaran per kecamatan tidak ada gunanya bagi akun kelurahan:
        // seluruh laporannya pasti berada di satu kecamatan yang sama.
        'tampilkan_kecamatan' => $adalahAdmin,

        // Sebaran per kelurahan hanya relevan kalau datanya lintas kelurahan.
        'tampilkan_kelurahan' => $adalahAdmin,

        // Menentukan munculnya tombol "Buat Pengaduan".
        'boleh_kelola' => $this->otorisasi()->bolehKelola(),
      ]
    ));
  }

  /** Akun kelurahan yang login beserta relasi wilayahnya, atau null bila admin. */
  private function akunKelurahan(): ?UserKelurahan
  {
    $akun = Auth::guard('kelurahan')->user();

    if (!$akun instanceof UserKelurahan) {
      return null;
    }

    $akun->loadMissing('kelurahan.kecamatan');

    return $akun;
  }
}
