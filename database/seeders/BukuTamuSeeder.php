<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Buku tamu kunjungan ke dinas.
 *
 * Format id mengikuti controller: tanggal kunjungan + 4 karakter acak.
 * Ketiga status (Pending, Diterima, Ditolak) sengaja terwakili supaya
 * tampilan badge status dan alur verifikasi admin bisa langsung diuji.
 */
class BukuTamuSeeder extends Seeder
{
  private const TAMU = [
    ['Andi Pratama', 'andi.pratama@example.com', '081234567801', 'Jl. Mawar No. 1, Samarinda', 'Konsultasi perizinan mendirikan bangunan', 'Diterima', 'Kunjungan disetujui, silakan datang sesuai jadwal.'],
    ['Siti Rahmawati', 'siti.rahmawati@example.com', '081234567802', 'Jl. Melati No. 12, Samarinda', 'Permohonan data rencana tata ruang', 'Diterima', 'Data dapat diambil di loket PPID.'],
    ['Bagas Wicaksono', 'bagas.w@example.com', '081234567803', 'Jl. Kenanga No. 5, Samarinda', 'Audiensi asosiasi jasa konstruksi', 'Pending', null],
    ['Dewi Lestari', 'dewi.lestari@example.com', '081234567804', 'Jl. Anggrek No. 8, Samarinda', 'Menanyakan progres perbaikan drainase lingkungan', 'Pending', null],
    ['Rudi Hartono', 'rudi.hartono@example.com', '081234567805', 'Jl. Cempaka No. 21, Samarinda', 'Penawaran produk material konstruksi', 'Ditolak', 'Penawaran komersial tidak dilayani melalui buku tamu.'],
  ];

  public function run(): void
  {
    $jabatan = DB::table('susunan_organisasi')
      ->where('is_subbagian', 0)
      ->orderBy('id_susunan_organisasi')
      ->pluck('id_susunan_organisasi')
      ->all();

    $baris = [];

    foreach (self::TAMU as $index => [$nama, $email, $telepon, $alamat, $maksud, $status, $keterangan]) {
      $kunjungan = now()->subDays($index * 3)->setTime(9, 0);

      $baris[] = [
        'id_buku_tamu' => $kunjungan->format('d-m-Y') . '-' . Str::lower(Str::random(4)),
        'nama_pengunjung' => $nama,
        'nomor_telepon' => $telepon,
        'email' => $email,
        'alamat' => $alamat,
        'jabatan_yang_dikunjungi' => $jabatan[$index % count($jabatan)],
        'maksud_dan_tujuan' => $maksud,
        'status' => $status,
        'deskripsi_status' => $keterangan,
        'created_at' => $kunjungan,
        'updated_at' => $kunjungan,
      ];
    }

    DB::table('buku_tamu')->insert($baris);
  }
}
