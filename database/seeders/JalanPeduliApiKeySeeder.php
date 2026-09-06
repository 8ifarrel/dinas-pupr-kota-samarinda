<?php

namespace Database\Seeders;

use App\Models\JalanPeduliApiKey;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Kunci API Jalan Peduli untuk integrasi pihak ketiga.
 *
 * Kunci pertama sengaja bernilai tetap agar mudah dipakai saat pengujian lokal.
 * Satu kunci nonaktif disertakan supaya penyaringan is_active ikut teruji.
 */
class JalanPeduliApiKeySeeder extends Seeder
{
  public function run(): void
  {
    $superAdmin = User::where('is_super_admin', 1)->value('id');

    JalanPeduliApiKey::create([
      'key' => 'test-api-key-12345',
      'name' => 'Kunci Uji Coba Lokal',
      'is_active' => true,
      'generated_by_user_id' => $superAdmin,
    ]);

    JalanPeduliApiKey::create([
      'key' => Str::random(32),
      'name' => 'Kunci Integrasi Peta Sebaran',
      'is_active' => true,
      'generated_by_user_id' => $superAdmin,
    ]);

    JalanPeduliApiKey::create([
      'key' => Str::random(32),
      'name' => 'Kunci Lama (Dicabut)',
      'is_active' => false,
      'generated_by_user_id' => $superAdmin,
    ]);
  }
}
