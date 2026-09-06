<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Riwayat pendidikan Kepala Dinas, urut dari jenjang terendah ke tertinggi.
 * Halaman publik menampilkannya terbalik (terbaru di atas) lewat orderBy desc.
 */
class KepalaDinasRiwayatPendidikanSeeder extends Seeder
{
  public function run(): void
  {
    $pendidikan = [
      ['SMA Negeri 1 Samarinda', '1986-07-14'],
      ['S1 Teknik Sipil - Universitas Mulawarman', '1989-08-21'],
      ['S2 Teknik Sipil (Manajemen Konstruksi) - Institut Teknologi Bandung', '2003-09-01'],
    ];

    $baris = [];
    $id = 1;

    foreach ($pendidikan as [$nama, $tanggal]) {
      $baris[] = [
        'id_pendidikan' => $id++,
        'id_kepala_dinas' => 1,
        'nama_pendidikan' => $nama,
        'tanggal_masuk' => $tanggal,
        'id_susunan_organisasi' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('kepala_dinas_riwayat_pendidikan')->insert($baris);
  }
}
