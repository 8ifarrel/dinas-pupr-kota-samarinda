<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Survei Kepuasan Masyarakat.
 *
 * Nilai memakai skala 1-4 (1 = tidak puas, 4 = sangat puas) dan disebar ke
 * seluruh layanan agar rekap nilai rata-rata per layanan ada isinya. Sebagian
 * responden mengisi kritik/saran, sebagian hanya memberi nilai - sesuai
 * kenyataan di lapangan dan karena kedua kolom itu memang boleh kosong.
 */
class SKMSeeder extends Seeder
{
  private const MASUKAN = [
    [4, 'Pelayanan sudah baik dan petugas ramah.', 'Pertahankan kecepatan responsnya.'],
    [4, null, 'Tambahkan kanal informasi via WhatsApp.'],
    [3, 'Waktu tunggu di loket masih cukup lama.', 'Perlu penambahan petugas saat jam sibuk.'],
    [3, null, null],
    [2, 'Informasi persyaratan kurang jelas di situs.', 'Mohon dibuatkan panduan langkah demi langkah.'],
    [4, 'Proses pengaduan mudah dipahami.', null],
    [1, 'Laporan saya belum ditindaklanjuti.', 'Mohon ada pemberitahuan status berkala.'],
    [3, null, 'Formulir daring sebaiknya bisa diakses dari ponsel.'],
  ];

  public function run(): void
  {
    $layanan = DB::table('layanan')->orderBy('id')->pluck('id')->all();

    if ($layanan === []) {
      return;
    }

    $baris = [];
    $id = 1;
    $urutan = 0;

    foreach ($layanan as $layananId) {
      foreach (self::MASUKAN as $index => [$nilai, $kritik, $saran]) {
        // Tidak semua layanan mendapat seluruh masukan, agar jumlah responden bervariasi.
        if (($index + $layananId) % 3 === 0) {
          continue;
        }

        $waktu = now()->subDays($urutan++)->setTime(13, 20);

        $baris[] = [
          'id' => $id++,
          'nilai' => $nilai,
          'ip_address' => '192.168.' . (($layananId % 5) + 1) . '.' . random_int(2, 250),
          'kritik' => $kritik,
          'saran' => $saran,
          'layanan_id' => $layananId,
          'created_at' => $waktu,
          'updated_at' => $waktu,
        ];
      }
    }

    DB::table('skm')->insert($baris);
  }
}
