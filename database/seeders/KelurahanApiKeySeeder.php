<?php

namespace Database\Seeders;

use App\Models\KelurahanApiKey;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Kunci API akun kelurahan untuk integrasi pihak ketiga.
 *
 * Kunci pertama sengaja bernilai tetap agar mudah dipakai saat pengujian lokal.
 * Satu kunci nonaktif disertakan supaya penyaringan is_active ikut teruji.
 */
class KelurahanApiKeySeeder extends Seeder
{
  public function run(): void
  {
    $superAdmin = User::where('is_super_admin', 1)->value('id');

    KelurahanApiKey::create([
      'key' => 'test-akun-kelurahan-key-12345',
      'name' => 'Kunci Uji Coba Lokal',
      'is_active' => true,
      'generated_by_user_id' => $superAdmin,
    ]);

    KelurahanApiKey::create([
      'key' => Str::random(32),
      'name' => 'Kunci Lama (Dicabut)',
      'is_active' => false,
      'generated_by_user_id' => $superAdmin,
    ]);
  }
}
