<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotoKegiatanSeeder extends Seeder
{
    public function run()
    {
        DB::table('foto_kegiatan')->insert([
            [
                'id' => 1,
                'foto' => 'foto1.jpg',
                'caption' => 'Foto kegiatan 1',
                'id_album_kegiatan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
