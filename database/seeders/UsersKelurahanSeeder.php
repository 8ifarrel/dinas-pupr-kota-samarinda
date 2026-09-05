<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersKelurahanSeeder extends Seeder
{
  /**
   * Dummy akun kelurahan.
   *
   * Setiap kelurahan (lihat KelurahanSeeder) mendapat satu akun dengan
   * username "kelurahan_<slug nama>" dan kata sandi "kelurahan123".
   * Bila ada nama kelurahan yang menghasilkan slug sama, id kelurahan
   * ditambahkan sebagai pembeda agar kolom "name" tetap unik.
   */
  public function run()
  {
    $now = now();
    $dipakai = [];

    // Bcrypt sengaja lambat; seluruh akun dummy memakai kata sandi yang sama,
    // jadi cukup di-hash sekali daripada sekali per kelurahan.
    $sandi = Hash::make('kelurahan123');

    $rows = DB::table('kelurahan')
      ->orderBy('id')
      ->get()
      ->map(function ($kelurahan) use ($now, $sandi, &$dipakai) {
        $name = 'kelurahan_' . Str::slug($kelurahan->nama, '');
        if (isset($dipakai[$name])) {
          $name .= '_' . $kelurahan->id;
        }
        $dipakai[$name] = true;

        return [
          'kelurahan_id' => $kelurahan->id,
          'fullname' => 'Operator Kelurahan ' . $kelurahan->nama,
          'name' => $name,
          'password' => $sandi,
          'remember_token' => null,
          'created_at' => $now,
          'updated_at' => $now,
        ];
      })
      ->all();

    DB::table('users_kelurahan')->insert($rows);
  }
}
