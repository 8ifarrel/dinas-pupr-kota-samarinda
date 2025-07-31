<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run()
    {
        DB::table('slider')->insert([
            [
                'id_slider' => 1,
                'judul_slider' => 'Slider 1',
                'foto_slider' => 'slider1.jpg',
                'nomor_urut_slider' => 1,
                'is_visible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
