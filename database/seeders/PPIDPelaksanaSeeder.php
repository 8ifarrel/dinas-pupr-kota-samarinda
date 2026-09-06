<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Dokumen yang dapat diunduh publik pada halaman PPID.
 *
 * Judul dokumen dipasangkan ke kategori yang sesuai agar isinya masuk akal
 * (mis. laporan keuangan tahunan masuk "Informasi Berkala").
 */
class PPIDPelaksanaSeeder extends Seeder
{
  private const DOKUMEN = [
    'Informasi Berkala' => [
      'Laporan Kinerja Instansi Pemerintah Tahun Terakhir',
      'Ringkasan Laporan Keuangan Dinas PUPR',
      'Rencana Strategis Dinas PUPR Kota Samarinda',
    ],
    'Informasi Serta Merta' => [
      'Peringatan Dini Potensi Banjir Kawasan Perkotaan',
      'Informasi Penutupan Ruas Jalan Akibat Perbaikan',
    ],
    'Informasi Setiap Saat' => [
      'Daftar Informasi Publik Dinas PUPR',
      'Standar Operasional Prosedur Pelayanan Perizinan',
      'Struktur Organisasi dan Tata Kerja',
    ],
    'Informasi Dikecualikan' => [
      'Daftar Informasi yang Dikecualikan Beserta Alasannya',
    ],
  ];

  public function run(): void
  {
    $kategori = DB::table('ppid_pelaksana_kategori')->pluck('id', 'nama');

    $baris = [];
    $id = 1;
    $selisihHari = 0;

    foreach (self::DOKUMEN as $namaKategori => $daftarJudul) {
      $idKategori = $kategori[$namaKategori] ?? null;

      if ($idKategori === null) {
        continue;
      }

      foreach ($daftarJudul as $judul) {
        $diunggah = now()->subDays($selisihHari++ * 4)->setTime(14, 0);
        $slug = Str::slug($judul);

        $baris[] = [
          'id' => $id++,
          'judul' => $judul,
          'slug' => $slug,
          'file' => DummyMedia::pdf(
            'Unduhan/' . $diunggah->format('Y-m/d') . "/{$slug}.pdf",
            $judul
          ),
          'id_kategori' => $idKategori,
          'download_count' => random_int(0, 95),
          'created_at' => $diunggah,
          'updated_at' => $diunggah,
        ];
      }
    }

    DB::table('ppid_pelaksana')->insert($baris);
  }
}
