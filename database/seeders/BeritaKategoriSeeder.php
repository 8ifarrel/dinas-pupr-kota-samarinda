<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Kategori berita mengikuti unit kerja: setiap Sekretariat, Bidang, dan UPTD
 * punya satu kategori sendiri sehingga berita dapat dikelompokkan per unit.
 */
class BeritaKategoriSeeder extends Seeder
{
  public function run(): void
  {
    $unit = DB::table('susunan_organisasi')
      ->where('is_subbagian', 0)
      ->where('kelompok_susunan_organisasi', '!=', 'Kepala Dinas')
      ->orderBy('id_susunan_organisasi')
      ->get(['id_susunan_organisasi', 'nama_susunan_organisasi', 'slug_susunan_organisasi']);

    $baris = [];
    $id = 1;

    foreach ($unit as $u) {
      $slug = $u->slug_susunan_organisasi;

      $baris[] = [
        'id_berita_kategori' => $id++,
        'id_susunan_organisasi' => $u->id_susunan_organisasi,
        'ikon_berita_kategori' => DummyMedia::gambar(
          "Berita/ikon/{$slug}.png",
          256,
          256,
          strtoupper($u->nama_susunan_organisasi),
          'berita'
        ),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('berita_kategori')->insert($baris);
  }
}
