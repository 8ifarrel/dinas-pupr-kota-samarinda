<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Jenjang karir Kepala Dinas, berurutan naik hingga jabatan saat ini
 * (Kepala Dinas sejak 2021, selaras dengan kolom tahun_mulai pada kepala_dinas).
 */
class KepalaDinasJenjangKarirSeeder extends Seeder
{
  public function run(): void
  {
    $karir = [
      ['Staf Bidang Bina Marga', '1998-03-01'],
      ['Kepala Seksi Perencanaan Jalan', '2006-04-17'],
      ['Kepala Bidang Bina Marga', '2014-01-06'],
      ['Sekretaris Dinas PUPR Kota Samarinda', '2018-02-12'],
      ['Kepala Dinas PUPR Kota Samarinda', '2021-05-03'],
    ];

    $baris = [];
    $id = 1;

    foreach ($karir as [$nama, $tanggal]) {
      $baris[] = [
        'id_karir' => $id++,
        'id_kepala_dinas' => 1,
        'nama_karir' => $nama,
        'tanggal_masuk' => $tanggal,
        'id_susunan_organisasi' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('kepala_dinas_jenjang_karir')->insert($baris);
  }
}
