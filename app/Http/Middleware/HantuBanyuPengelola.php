<?php

namespace App\Http\Middleware;

use App\Support\HantuBanyu\OtorisasiPengelola;
use Closure;
use Illuminate\Http\Request;

/**
 * Jaga aksi yang MENGUBAH data Hantu Banyu: membuat laporan dan memperbarui
 * tindak lanjutnya.
 *
 * Melihat isi Hantu Banyu terbuka untuk seluruh admin - itu memang informasi
 * lintas unit. Yang dijaga di sini hanya hak mengubahnya, yang dipegang unit
 * pemilik layanan (plus super admin) dan akun kelurahan di wilayahnya sendiri.
 *
 * Penjagaan ini melengkapi, bukan menggantikan, penyembunyian tombol di
 * tampilan: tombol yang hilang tidak menghalangi permintaan yang dikirim
 * langsung ke rutenya.
 */
class HantuBanyuPengelola
{
  public function handle(Request $request, Closure $next)
  {
    $otorisasi = new OtorisasiPengelola();

    if (!$otorisasi->bolehKelola()) {
      abort(403, 'Hanya ' . $otorisasi->namaUnitPemilik()
        . ' yang dapat mengelola laporan Hantu Banyu. Akun Anda tetap dapat melihat seluruh datanya.');
    }

    return $next($request);
  }
}
