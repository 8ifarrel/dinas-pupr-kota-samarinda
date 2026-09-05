<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Agenda kegiatan dinas.
 *
 * Sengaja disebar pada minggu berjalan serta satu minggu sebelum dan sesudahnya,
 * karena beranda menampilkan agenda minggu berjalan dan penggunanya dapat
 * menggeser ke minggu sebelumnya/berikutnya. Ada hari yang kosong dan ada hari
 * berisi lebih dari satu agenda supaya kedua kondisi tampilan ikut teruji.
 */
class AgendaKegiatanSeeder extends Seeder
{
  /** [selisih hari dari Senin minggu ini, jam mulai, nama, tempat, pelaksana, dihadiri]. */
  private const AGENDA = [
    [-5, '09:00', 'Rapat Evaluasi Progres Pembangunan Drainase', 'Ruang Rapat Utama Dinas PUPR', 'Bidang Sumber Daya Air', 'Kepala Dinas dan Kepala Bidang'],
    [-3, '13:30', 'Koordinasi Penataan Ruang dengan Kecamatan', 'Aula Kantor Kecamatan Samarinda Ulu', 'Bidang Tata Ruang', 'Camat dan Lurah se-Kecamatan'],
    [0, '08:00', 'Apel Pagi dan Pembinaan Pegawai', 'Halaman Kantor Dinas PUPR', 'Sekretariat', 'Seluruh pegawai'],
    [0, '10:00', 'Tinjauan Lapangan Perbaikan Jalan Poros', 'Jalan Poros Samarinda Utara', 'Bidang Bina Marga', 'Kepala Dinas dan tim teknis'],
    [1, '09:30', 'Sosialisasi Perizinan Jasa Konstruksi', 'Ruang Serbaguna Dinas PUPR', 'Bidang Bina Konstruksi', 'Asosiasi penyedia jasa konstruksi'],
    [2, '14:00', 'Rapat Anggaran Perubahan', 'Ruang Rapat Sekretariat', 'Subbagian Keuangan', 'Sekretaris dan Kasubbag'],
    [4, '08:30', 'Kerja Bakti Normalisasi Saluran', 'Kawasan Pasar Segiri', 'UPTD Pemeliharaan Saluran Drainase dan Irigasi', 'Petugas UPTD dan warga'],
    [7, '09:00', 'Konsultasi Publik Rencana Detail Tata Ruang', 'Aula Bappeda Kota Samarinda', 'Bidang Tata Ruang', 'Perwakilan masyarakat dan akademisi'],
    [9, '10:30', 'Monitoring Pemeliharaan Jembatan', 'Jembatan Mahakam', 'UPTD Pemeliharaan Jalan dan Jembatan', 'Tim teknis UPTD'],
    [11, '13:00', 'Rapat Persiapan Musrenbang', 'Ruang Rapat Utama Dinas PUPR', 'Subbagian Program', 'Kepala Bidang dan Kasubbag'],
  ];

  public function run(): void
  {
    $awalMinggu = now()->startOfWeek();

    $baris = [];
    $id = 1;

    foreach (self::AGENDA as [$selisih, $jam, $nama, $tempat, $pelaksana, $dihadiri]) {
      $tanggal = $awalMinggu->copy()->addDays($selisih);

      $baris[] = [
        'id' => $id++,
        'nama' => $nama,
        'waktu_mulai' => $jam . ':00',
        'tempat' => $tempat,
        'pelaksana' => $pelaksana,
        'dihadiri_oleh' => $dihadiri,
        'tanggal' => $tanggal->toDateString(),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('agenda_kegiatan')->insert($baris);
  }
}
