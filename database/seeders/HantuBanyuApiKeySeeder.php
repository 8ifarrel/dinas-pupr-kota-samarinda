<?php

namespace Database\Seeders;

use App\Models\HantuBanyuApiKey;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Kunci API Hantu Banyu untuk integrasi pihak ketiga.
 *
 * Kunci pertama sengaja bernilai tetap agar mudah dipakai saat pengujian lokal.
 * Satu kunci nonaktif disertakan supaya penyaringan is_active ikut teruji.
 */
class HantuBanyuApiKeySeeder extends Seeder
{
  public function run(): void
  {
    $superAdmin = User::where('is_super_admin', 1)->value('id');

    HantuBanyuApiKey::create([
      'key' => 'test-hantu-banyu-key-12345',
      'name' => 'Kunci Uji Coba Lokal',
      'is_active' => true,
      'generated_by_user_id' => $superAdmin,
    ]);

    HantuBanyuApiKey::create([
      'key' => Str::random(32),
      'name' => 'Kunci Lama (Dicabut)',
      'is_active' => false,
      'generated_by_user_id' => $superAdmin,
    ]);
  }
}
