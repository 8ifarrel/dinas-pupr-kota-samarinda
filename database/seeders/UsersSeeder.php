<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Akun pengelola panel admin.
 *
 * Terdiri dari satu super admin (akses penuh, termasuk menu Super Admin) dan
 * satu admin untuk tiap unit kerja tingkat atas. Admin unit dipakai untuk
 * menguji pembatasan hak akses berbasis id_susunan_organisasi - mis. admin
 * bidang hanya mengelola berita kategorinya sendiri.
 */
class UsersSeeder extends Seeder
{
  public function run(): void
  {
    // Bcrypt sengaja lambat; seluruh akun dummy memakai kata sandi yang sama,
    // jadi cukup di-hash sekali daripada sekali per akun.
    $sandiAdmin = Hash::make('admin123');

    DB::table('users')->insert([
      'id' => 1,
      'id_susunan_organisasi' => null,
      'fullname' => 'Super Admin',
      'name' => 'super_admin',
      'email' => null,
      'email_verified_at' => null,
      'password' => Hash::make('SayaMakanAyam@910910'),
      'is_super_admin' => 1,
      'remember_token' => null,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    $unit = DB::table('susunan_organisasi')
      ->where('is_subbagian', 0)
      ->orderBy('id_susunan_organisasi')
      ->get(['id_susunan_organisasi', 'nama_susunan_organisasi']);

    $baris = [];
    $id = 2;

    foreach ($unit as $u) {
      $baris[] = [
        'id' => $id++,
        'id_susunan_organisasi' => $u->id_susunan_organisasi,
        'fullname' => 'Admin ' . $u->nama_susunan_organisasi,
        'name' => 'admin_' . Str::slug($u->nama_susunan_organisasi, '_'),
        'email' => null,
        'email_verified_at' => null,
        'password' => $sandiAdmin,
        'is_super_admin' => 0,
        'remember_token' => null,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('users')->insert($baris);
  }
}
