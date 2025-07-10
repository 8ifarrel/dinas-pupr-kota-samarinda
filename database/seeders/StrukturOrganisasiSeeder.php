<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 7; $i++) {
            DB::table('struktur_organisasi')->insert([
                'id_jabatan' => $i,
                'nomor_urut_jabatan' => $i,
                'ikon_jabatan' => $faker->imageUrl(),
            ]);
        }
    }
}

