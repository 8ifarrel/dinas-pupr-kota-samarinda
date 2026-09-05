<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Galeri foto kegiatan tiap unit kerja pada halaman detail struktur organisasi.
 */
class StrukturOrganisasiSliderSeeder extends Seeder
{
  private const FOTO_PER_UNIT = 3;

  public function run(): void
  {
    $struktur = DB::table('struktur_organisasi as st')
      ->join('susunan_organisasi as su', 'su.id_susunan_organisasi', '=', 'st.id_susunan_organisasi')
      ->orderBy('st.nomor_urut_jabatan')
      ->get(['st.id_struktur_organisasi', 'su.nama_susunan_organisasi', 'su.slug_susunan_organisasi']);

    $baris = [];
    $id = 1;

    foreach ($struktur as $s) {
      $slug = $s->slug_susunan_organisasi;

      for ($i = 1; $i <= self::FOTO_PER_UNIT; $i++) {
        $baris[] = [
          'id_slider' => $id++,
          'id_struktur_organisasi' => $s->id_struktur_organisasi,
          'foto' => DummyMedia::gambar(
            "struktur-organisasi/{$slug}/slider/{$slug}-{$i}.png",
            1280,
            720,
            strtoupper($s->nama_susunan_organisasi) . " FOTO {$i}",
            'struktur'
          ),
          'keterangan' => 'Dokumentasi kegiatan ' . $s->nama_susunan_organisasi . ' (' . $i . ').',
          'created_at' => now(),
          'updated_at' => now(),
        ];
      }
    }

    DB::table('struktur_organisasi_slider')->insert($baris);
  }
}
