<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Profil Kepala Dinas yang tampil di beranda dan halaman Profil Kepala Dinas.
 *
 * Hanya ada satu baris: id_susunan_organisasi 1 (Kepala Dinas), karena
 * controller memang mencari unit tersebut untuk menampilkan sambutan.
 */
class KepalaDinasSeeder extends Seeder
{
  public const NAMA = 'Ir. Budi Santosa, S.T., M.T.';

  public function run(): void
  {
    $slug = Str::slug(self::NAMA);

    DB::table('kepala_dinas')->insert([
      'id' => 1,
      'nama' => self::NAMA,
      'foto' => DummyMedia::gambar(
        "pegawai/kepala-dinas/{$slug}.png",
        800,
        1000,
        'KEPALA DINAS',
        'pegawai'
      ),
      'nip' => '197105121998031004',
      'nomor_telepon' => '0541-741234',
      'golongan' => 'IV/b',
      'tahun_mulai' => 2021,
      'tahun_selesai' => 2026,
      'id_susunan_organisasi' => 1,
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
