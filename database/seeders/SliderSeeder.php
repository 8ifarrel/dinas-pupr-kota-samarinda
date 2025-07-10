<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('slider')->insert([
                'foto_slider' => $faker->imageUrl(1280, 549, 'business', true, 'Faker'),
                'nomor_urut_slider' => $i,
                'judul_slider' => $faker->sentence(3),
                'is_visible' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

