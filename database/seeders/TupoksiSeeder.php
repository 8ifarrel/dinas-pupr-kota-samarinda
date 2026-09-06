<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Tugas pokok dan fungsi dinas.
 *
 * Controller hanya mengambil baris pertama (Tupoksi::first()), jadi cukup satu
 * baris saja - halaman ini memang bersifat tunggal seperti Visi dan Sejarah.
 */
class TupoksiSeeder extends Seeder
{
  public function run(): void
  {
    DB::table('tupoksi')->insert([
      'id' => 1,
      'tugas' => '<p>Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda mempunyai tugas membantu '
        . 'Wali Kota dalam melaksanakan urusan pemerintahan bidang pekerjaan umum dan penataan ruang '
        . 'serta bidang pertanahan yang menjadi kewenangan daerah, dan tugas pembantuan yang '
        . 'ditugaskan kepada daerah.</p>',
      'pokok' => '<p>Menyelenggarakan perumusan kebijakan teknis, pelaksanaan, pembinaan, pengawasan, '
        . 'dan pengendalian di bidang sumber daya air, bina marga, cipta karya, bina konstruksi, '
        . 'tata ruang, serta pertanahan di wilayah Kota Samarinda.</p>',
      'fungsi' => '<ol>'
        . '<li>Perumusan kebijakan teknis di bidang pekerjaan umum dan penataan ruang.</li>'
        . '<li>Pelaksanaan kebijakan di bidang pekerjaan umum dan penataan ruang.</li>'
        . '<li>Pelaksanaan evaluasi dan pelaporan di bidang pekerjaan umum dan penataan ruang.</li>'
        . '<li>Pelaksanaan administrasi dinas sesuai dengan lingkup tugasnya.</li>'
        . '<li>Pembinaan terhadap Unit Pelaksana Teknis Daerah di lingkungan dinas.</li>'
        . '<li>Pelaksanaan fungsi lain yang diberikan oleh Wali Kota sesuai tugas dan fungsinya.</li>'
        . '</ol>',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
