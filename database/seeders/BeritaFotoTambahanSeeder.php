<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaFotoTambahanSeeder extends Seeder
{
    public function run()
    {
        $berita = DB::table('berita')->first();
        DB::table('berita_foto_tambahan')->insert([
            [
                'uuid_berita' => $berita->uuid_berita,
                'foto_path' => 'berita1_extra.jpg',
                'caption' => 'Foto tambahan berita 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
