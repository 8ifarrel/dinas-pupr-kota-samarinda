<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PpidPelaksanaKategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('ppid_pelaksana_kategori')->insert([
            [
                'id' => 1,
                'nama' => 'Kategori 1',
                'slug' => 'kategori-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
