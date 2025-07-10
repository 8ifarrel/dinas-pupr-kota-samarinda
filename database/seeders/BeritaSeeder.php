<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 100; $i++) {
            DB::table('berita')->insert([
                'uuid_berita' => Str::uuid(),
                'judul_berita' => $faker->sentence($nbWords = rand(10, 20)),
                'slug_berita' => $faker->slug,
                'id_berita_kategori' => $faker->numberBetween(1, 5),
                'foto_berita' => $faker->imageUrl(320, 180, 'news'),
                'sumber_foto_berita' => $faker->name,
                'isi_berita' => $faker->paragraphs(5, true),
                'views_count' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

