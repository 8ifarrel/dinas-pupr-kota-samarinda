<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
  /** Id layanan untuk survei umum, yaitu survei yang tidak terikat fitur mana pun. */
  public const ID_UMUM = 0;

  public function run(): void
  {
    // Kolom id bersifat AUTO_INCREMENT, dan MySQL secara bawaan mengubah nilai 0
    // menjadi nomor urut berikutnya. Mode NO_AUTO_VALUE_ON_ZERO membuat angka 0
    // tersimpan apa adanya, sehingga layanan "umum" benar-benar ber-id 0.
    DB::statement("SET SESSION sql_mode = CONCAT(@@sql_mode, ',NO_AUTO_VALUE_ON_ZERO')");

    $data = [
      ['id' => self::ID_UMUM, 'nama' => 'umum',        'struktur_organisasi_id' => null],
      ['id' => 1,             'nama' => 'gistaru',     'struktur_organisasi_id' => 6],
      ['id' => 2,             'nama' => 'sijakon',     'struktur_organisasi_id' => 5],
      ['id' => 3,             'nama' => 'jalan_peduli', 'struktur_organisasi_id' => 9],
      ['id' => 5,             'nama' => 'hantu_banyu', 'struktur_organisasi_id' => 10],
      ['id' => 6,             'nama' => 'sedot_tinja', 'struktur_organisasi_id' => 8],
    ];

    foreach ($data as $layanan) {
      Layanan::updateOrCreate(['id' => $layanan['id']], $layanan);
    }

    DB::statement("SET SESSION sql_mode = REPLACE(@@sql_mode, ',NO_AUTO_VALUE_ON_ZERO', '')");
  }
}
