<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StrukturOrganisasiSliderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('struktur_organisasi_slider')->insert([
                'id_jabatan' => $faker->numberBetween(1, 10), // Pastikan id_jabatan ini sesuai dengan data yang ada di tabel jabatan
                'foto' => $faker->imageUrl($width = 640, $height = 360),
                'keterangan' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

