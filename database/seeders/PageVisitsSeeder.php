<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Catatan kunjungan per halaman.
 *
 * visitor_id mengacu ke kolom visitor_id pada tabel visitors (bukan id numerik),
 * sesuai cara middleware RecordStatistikPengunjung mencatat. Nilai konteks
 * halaman diambil dari properti page_context milik controller agar rekapnya
 * cocok dengan yang benar-benar dicatat saat aplikasi berjalan.
 */
class PageVisitsSeeder extends Seeder
{
  /** Bobot kemunculan: beranda paling sering dikunjungi. */
  private const KONTEKS = [
    'Beranda', 'Beranda', 'Beranda', 'Beranda',
    'Berita', 'Berita', 'Berita',
    'Pengumuman', 'Pengumuman',
    'PPID Pelaksana',
    'Album Kegiatan',
    'Struktur Organisasi',
    'Profil Kepala Dinas',
    'Visi dan Misi',
    'Sejarah',
    'Buku Tamu',
    'Hantu Banyu', 'Hantu Banyu',
    'Portal',
    'Kebijakan Privasi',
  ];

  public function run(): void
  {
    $visitor = DB::table('visitors')->get(['visitor_id', 'first_visit_at']);

    $baris = [];

    foreach ($visitor as $v) {
      $mulai = Carbon::parse($v->first_visit_at);

      // Satu pengunjung membuka beberapa halaman dalam satu sesi.
      $jumlah = random_int(1, 5);

      for ($i = 0; $i < $jumlah; $i++) {
        $baris[] = [
          'visitor_id' => $v->visitor_id,
          'visited_page_context' => self::KONTEKS[array_rand(self::KONTEKS)],
          'visited_at' => $mulai->copy()->addMinutes($i * random_int(1, 6)),
        ];
      }
    }

    foreach (array_chunk($baris, 200) as $bagian) {
      DB::table('page_visits')->insert($bagian);
    }
  }
}
