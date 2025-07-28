<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kecamatan')->insert([
            ['id' => 1, 'nama' => 'Samarinda Ulu'],
            ['id' => 2, 'nama' => 'Samarinda Ilir'],
        ]);
    }
}
