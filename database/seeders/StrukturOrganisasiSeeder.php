<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Kartu unit kerja yang tampil di halaman Struktur Organisasi.
 *
 * Hanya unit tingkat atas yang ditampilkan (Sekretariat, Bidang, dan UPTD) -
 * subbagian tidak diberi kartu sendiri. Urutan kartu mengikuti urutan
 * id_susunan_organisasi agar sesuai bagan resmi dinas.
 */
class StrukturOrganisasiSeeder extends Seeder
{
  public function run(): void
  {
    $unit = DB::table('susunan_organisasi')
      ->where('is_subbagian', 0)
      ->where('kelompok_susunan_organisasi', '!=', 'Kepala Dinas')
      ->orderBy('id_susunan_organisasi')
      ->get(['id_susunan_organisasi', 'nama_susunan_organisasi', 'slug_susunan_organisasi']);

    $baris = [];
    $urut = 1;

    foreach ($unit as $u) {
      $slug = $u->slug_susunan_organisasi;

      $ikon = DummyMedia::gambar(
        "struktur-organisasi/{$slug}/ikon/{$slug}.png",
        256,
        256,
        strtoupper($u->nama_susunan_organisasi),
        'struktur'
      );

      $baris[] = [
        'id_struktur_organisasi' => $urut,
        'id_susunan_organisasi' => $u->id_susunan_organisasi,
        'ikon_jabatan' => $ikon,
        'nomor_urut_jabatan' => $urut,
        'created_at' => now(),
        'updated_at' => now(),
      ];

      $urut++;
    }

    DB::table('struktur_organisasi')->insert($baris);
  }
}
