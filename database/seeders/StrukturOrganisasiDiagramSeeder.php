<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Diagram organisasi terdiri dari dua jenis baris:
 * 1. Satu baris umum (id_struktur_organisasi NULL) - organigram utama Dinas,
 *    ditampilkan di halaman index profil & diedit lewat OrganigramAdminController
 *    yang meng-hardcode id 1, jadi baris ini WAJIB berada di id pertama.
 * 2. Satu baris per jabatan struktur organisasi - bagan internal unit yang
 *    ditampilkan di halaman show milik jabatan tersebut.
 */
class StrukturOrganisasiDiagramSeeder extends Seeder
{
  public function run(): void
  {
    $baris = [
      [
        'id_struktur_organisasi_diagram' => 1,
        'id_struktur_organisasi' => null,
        'diagram_struktur_organisasi' => DummyMedia::gambar(
          'struktur-organisasi/organigram-dinas.png',
          1600,
          900,
          'ORGANIGRAM DINAS PUPR KOTA SAMARINDA',
          'struktur'
        ),
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    $struktur = DB::table('struktur_organisasi as st')
      ->join('susunan_organisasi as su', 'su.id_susunan_organisasi', '=', 'st.id_susunan_organisasi')
      ->orderBy('st.nomor_urut_jabatan')
      ->get(['st.id_struktur_organisasi', 'su.nama_susunan_organisasi', 'su.slug_susunan_organisasi']);

    $id = 2;

    foreach ($struktur as $s) {
      $slug = $s->slug_susunan_organisasi;

      $baris[] = [
        'id_struktur_organisasi_diagram' => $id++,
        'id_struktur_organisasi' => $s->id_struktur_organisasi,
        'diagram_struktur_organisasi' => DummyMedia::gambar(
          "struktur-organisasi/{$slug}/diagram/{$slug}.png",
          1600,
          900,
          'BAGAN ' . strtoupper($s->nama_susunan_organisasi),
          'struktur'
        ),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('struktur_organisasi_diagram')->insert($baris);
  }
}
