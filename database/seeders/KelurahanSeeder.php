<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kelurahan')->insert([
            ['id' => 1, 'nama' => 'Kelurahan A', 'kecamatan_id' => 1],
            ['id' => 2, 'nama' => 'Kelurahan B', 'kecamatan_id' => 2],
        ]);
    }
}
