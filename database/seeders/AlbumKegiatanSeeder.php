<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumKegiatanSeeder extends Seeder
{
    public function run()
    {
        DB::table('album_kegiatan')->insert([
            [
                'id' => 1,
                'judul' => 'Kegiatan 1',
                'slug' => 'kegiatan-1',
                'views_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
