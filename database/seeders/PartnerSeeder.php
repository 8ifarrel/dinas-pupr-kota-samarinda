<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PartnerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('partner')->insert([
                'foto_partner' => $faker->imageUrl(),
                'nama_partner' => $faker->company,
                'url_partner' => $faker->url,
            ]);
        }
    }
}

