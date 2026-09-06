<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Kategori dokumen PPID mengikuti klasifikasi informasi publik pada
 * UU Keterbukaan Informasi Publik, karena itulah pengelompokan yang
 * dipakai halaman PPID di sisi publik.
 */
class PPIDPelaksanaKategoriSeeder extends Seeder
{
  public const KATEGORI = [
    'Informasi Berkala',
    'Informasi Serta Merta',
    'Informasi Setiap Saat',
    'Informasi Dikecualikan',
  ];

  public function run(): void
  {
    $baris = [];
    $id = 1;

    foreach (self::KATEGORI as $nama) {
      $baris[] = [
        'id' => $id++,
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('ppid_pelaksana_kategori')->insert($baris);
  }
}
