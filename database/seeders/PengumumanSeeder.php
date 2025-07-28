<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengumuman')->insert([
            [
                'id' => 1,
                'judul_pengumuman' => 'Pengumuman 1',
                'slug_pengumuman' => 'pengumuman-1',
                'perihal' => 'Perihal pengumuman 1',
                'file_lampiran' => 'lampiran1.pdf',
                'views_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
