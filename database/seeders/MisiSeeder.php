<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $misiData = [];

        for ($i = 1; $i <= 5; $i++) {
            $misiData[] = [
                'nomor_urut' => $i,
                'deskripsi_misi' => $faker->sentence,
                'periode_mulai' => 2021,
                'periode_selesai' => 2026,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('misi')->insert($misiData);
    }
}

