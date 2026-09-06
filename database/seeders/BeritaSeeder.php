<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Berita untuk setiap kategori/unit kerja.
 *
 * Judul dirakit dari nama unit agar isinya masuk akal terhadap kategorinya,
 * dan tanggal terbit dibuat menyebar mundur supaya urutan "berita terkini"
 * di beranda terlihat wajar.
 */
class BeritaSeeder extends Seeder
{
  private const BERITA_PER_KATEGORI = 3;

  private const POLA_JUDUL = [
    'Percepatan Program %s Tahun Ini',
    'Tinjauan Lapangan %s Bersama Wali Kota',
    'Sosialisasi Program Kerja %s kepada Masyarakat',
  ];

  public function run(): void
  {
    $kategori = DB::table('berita_kategori as bk')
      ->join('susunan_organisasi as su', 'su.id_susunan_organisasi', '=', 'bk.id_susunan_organisasi')
      ->orderBy('bk.id_berita_kategori')
      ->get(['bk.id_berita_kategori', 'su.nama_susunan_organisasi']);

    $baris = [];
    $selisihHari = 0;

    foreach ($kategori as $k) {
      for ($i = 0; $i < self::BERITA_PER_KATEGORI; $i++) {
        $terbit = now()->subDays($selisihHari++)->setTime(9, 30);
        $judul = sprintf(self::POLA_JUDUL[$i], $k->nama_susunan_organisasi);
        $uuid = (string) Str::uuid();
        $slug = Str::slug($judul);

        $foto = DummyMedia::gambar(
          'Berita/' . $terbit->format('Y-m') . '/' . $terbit->format('d') . "/{$uuid}.png",
          1280,
          720,
          strtoupper($k->nama_susunan_organisasi),
          'berita'
        );

        $baris[] = [
          'uuid_berita' => $uuid,
          'judul_berita' => $judul,
          'slug_berita' => $slug,
          'id_berita_kategori' => $k->id_berita_kategori,
          'foto_berita' => $foto,
          'sumber_foto_berita' => 'Dokumentasi Dinas PUPR Kota Samarinda',
          'isi_berita' => '<p>' . $judul . '.</p><p>Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melalui '
            . $k->nama_susunan_organisasi . ' melanjutkan pelaksanaan program kerja yang telah ditetapkan. '
            . 'Kegiatan ini menjadi bagian dari upaya peningkatan kualitas infrastruktur dan pelayanan '
            . 'kepada masyarakat Kota Samarinda.</p><p>Masyarakat dapat menyampaikan masukan melalui kanal '
            . 'pengaduan resmi yang tersedia pada situs ini.</p>',
          'preview_berita' => Str::limit(strip_tags($judul . '. Kegiatan ' . $k->nama_susunan_organisasi
            . ' dalam rangka peningkatan kualitas infrastruktur Kota Samarinda.'), 150),
          'views_count' => random_int(15, 480),
          'created_at' => $terbit,
          'updated_at' => $terbit,
        ];
      }
    }

    DB::table('berita')->insert($baris);
  }
}
