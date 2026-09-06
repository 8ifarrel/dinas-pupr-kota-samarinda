<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Slider hero di beranda. Rasio 21:9 mengikuti area tampilan carousel.
 * Satu slider sengaja dinonaktifkan (is_visible = 0) agar penyaringan
 * "hanya tampilkan yang aktif" pada beranda ikut teruji.
 */
class SliderSeeder extends Seeder
{
  public function run(): void
  {
    $slider = [
      ['Pembangunan Infrastruktur Kota Samarinda', 1, true],
      ['Layanan Pengaduan Masyarakat Kini Lebih Mudah', 2, true],
      ['Menata Ruang Kota untuk Generasi Mendatang', 3, true],
      ['Arsip Slider Lama', 4, false],
    ];

    $baris = [];
    $id = 1;

    foreach ($slider as [$judul, $urut, $tampil]) {
      $slug = Str::slug($judul);

      $baris[] = [
        'id_slider' => $id++,
        'judul_slider' => $judul,
        'foto_slider' => DummyMedia::gambar(
          "Slider/{$slug}-{$urut}.png",
          1920,
          823,
          strtoupper(Str::limit($judul, 40, '')),
          'slider'
        ),
        'nomor_urut_slider' => $urut,
        'is_visible' => $tampil ? 1 : 0,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('slider')->insert($baris);
  }
}
