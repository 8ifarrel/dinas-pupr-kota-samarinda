<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kecamatans')->insert([
            ['id' => 3139, 'nama' => 'Loa Janan Ilir'],
            ['id' => 3140, 'nama' => 'Palaran'],
            ['id' => 3141, 'nama' => 'Samarinda Ilir'],
            ['id' => 3142, 'nama' => 'Samarinda Kota'],
            ['id' => 3143, 'nama' => 'Samarinda Seberang'],
            ['id' => 3144, 'nama' => 'Samarinda Ulu'],
            ['id' => 3145, 'nama' => 'Samarinda Utara'],
            ['id' => 3146, 'nama' => 'Sambutan'],
            ['id' => 3147, 'nama' => 'Sungai Kunjang'],
            ['id' => 3148, 'nama' => 'Sungai Pinang'],
        ]);
    }
}
