<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BeritaKategoriSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 1; $i <= 5; $i++) {
            DB::table('berita_kategori')->insert([
                'id_jabatan' => $faker->numberBetween(1, 5), 
                'ikon_berita_kategori' => $faker->imageUrl(100, 100, 'abstract'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

