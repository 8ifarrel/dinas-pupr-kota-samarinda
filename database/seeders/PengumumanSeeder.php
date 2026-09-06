<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Pengumuman resmi dinas. Sebagian dilengkapi lampiran PDF dan sebagian tidak,
 * karena kolom file_lampiran memang boleh kosong dan tampilannya berbeda.
 */
class PengumumanSeeder extends Seeder
{
  public function run(): void
  {
    $pengumuman = [
      ['Pengumuman Seleksi Penyedia Jasa Konstruksi Tahun Anggaran Berjalan', true],
      ['Jadwal Pemeliharaan Saluran Drainase Wilayah Samarinda Ulu', true],
      ['Pemberitahuan Penyesuaian Jam Pelayanan Loket PPID', false],
      ['Undangan Konsultasi Publik Rencana Detail Tata Ruang', true],
    ];

    $baris = [];
    $id = 1;

    foreach ($pengumuman as $index => [$judul, $adaLampiran]) {
      $terbit = now()->subDays($index * 6)->setTime(8, 0);
      $slug = Str::slug($judul);

      $lampiran = null;
      if ($adaLampiran) {
        $lampiran = DummyMedia::pdf("Pengumuman/{$slug}.pdf", $judul);
      }

      $baris[] = [
        'id' => $id++,
        'judul_pengumuman' => $judul,
        'slug_pengumuman' => $slug,
        'perihal' => '<p>' . $judul . '.</p><p>Sehubungan dengan hal tersebut, seluruh pihak terkait '
          . 'diharapkan memperhatikan ketentuan yang berlaku. Informasi lebih lanjut dapat diperoleh '
          . 'melalui kantor Dinas PUPR Kota Samarinda pada hari dan jam kerja.</p>',
        'file_lampiran' => $lampiran,
        'views_count' => random_int(5, 220),
        'created_at' => $terbit,
        'updated_at' => $terbit,
      ];
    }

    DB::table('pengumuman')->insert($baris);
  }
}
