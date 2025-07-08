<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MediaAlbumSeeder extends Seeder {
    public function run() {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('media_album')->insert([
                'judul' => "Album $i",
                'slug' => Str::slug("Album $i"),
                'views_count' => $faker->numberBetween(0, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
