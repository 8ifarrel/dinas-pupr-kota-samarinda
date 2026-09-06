<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Logo instansi mitra yang berjalan otomatis (auto-scroll) di beranda.
 * Logo dibuat memanjang karena ditampilkan dengan tinggi tetap.
 */
class PartnerSeeder extends Seeder
{
  public function run(): void
  {
    $partner = [
      ['Pemerintah Kota Samarinda', 'https://www.samarindakota.go.id'],
      ['Kementerian PUPR', 'https://www.pu.go.id'],
      ['Pemerintah Provinsi Kalimantan Timur', 'https://kaltimprov.go.id'],
      ['Badan Perencanaan Pembangunan Daerah', 'https://bappeda.samarindakota.go.id'],
      ['Perumda Tirta Kencana', 'https://tirtakencana.co.id'],
      ['Dinas Perhubungan Kota Samarinda', 'https://dishub.samarindakota.go.id'],
    ];

    $baris = [];
    $id = 1;

    foreach ($partner as [$nama, $url]) {
      $slug = Str::slug($nama);

      $baris[] = [
        'id_partner' => $id++,
        'nama_partner' => $nama,
        'foto_partner' => DummyMedia::gambar(
          "partner/{$slug}.png",
          480,
          160,
          strtoupper(Str::limit($nama, 34, '')),
          'partner'
        ),
        'url_partner' => $url,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('partner')->insert($baris);
  }
}
