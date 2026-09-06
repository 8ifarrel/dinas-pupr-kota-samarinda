<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Album galeri kegiatan. Fotonya diisi oleh FotoKegiatanSeeder, yang menyimpan
 * berkas ke folder album-kegiatan/{slug} sesuai perilaku controller.
 */
class AlbumKegiatanSeeder extends Seeder
{
  public const ALBUM = [
    'Peninjauan Proyek Peningkatan Jalan Poros Kota',
    'Normalisasi Saluran Drainase Kawasan Pasar Segiri',
    'Sosialisasi Rencana Tata Ruang kepada Warga',
    'Apel Pagi dan Pembinaan Pegawai Dinas PUPR',
  ];

  public function run(): void
  {
    $baris = [];
    $id = 1;

    foreach (self::ALBUM as $index => $judul) {
      $dibuat = now()->subDays($index * 9)->setTime(10, 15);

      $baris[] = [
        'id' => $id++,
        'judul' => $judul,
        'slug' => Str::slug($judul),
        'views_count' => random_int(8, 160),
        'created_at' => $dibuat,
        'updated_at' => $dibuat,
      ];
    }

    DB::table('album_kegiatan')->insert($baris);
  }
}
