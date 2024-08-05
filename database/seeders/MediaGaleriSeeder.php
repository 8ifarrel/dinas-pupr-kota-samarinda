<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\MediaAlbum;
use Faker\Factory as Faker;

class MediaGaleriSeeder extends Seeder {
    public function run() {
        $faker = Faker::create();
        $albumIds = MediaAlbum::all()->pluck('id')->toArray();
        $resolutions = [
            [640, 360], // 360p
            [1280, 720], // 720p
            [1920, 1080], // 1080p
            [800, 600], // 4:3 aspect ratio
            [1024, 768], // 4:3 aspect ratio
            [1280, 1024], // 5:4 aspect ratio
            [1366, 768], // 16:9 aspect ratio
            [1600, 900], // 16:9 aspect ratio
            [1920, 1200], // 16:10 aspect ratio
        ];

        for ($i = 1; $i <= 120; $i++) {
            $resolution = $faker->randomElement($resolutions);
            $width = $resolution[0];
            $height = $resolution[1];

            DB::table('media_galeri')->insert([
                'uuid' => Str::uuid(),
                'foto' => $faker->imageUrl($width, $height, 'cats', true, 'Faker'),
                'caption' => $faker->sentence,
                'id_media_album' => $faker->randomElement($albumIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
