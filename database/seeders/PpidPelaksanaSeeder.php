<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PpidPelaksanaSeeder extends Seeder
{
    public function run()
    {
        DB::table('ppid_pelaksana')->insert([
            [
                'id' => 1,
                'judul' => 'Dokumen 1',
                'slug' => 'dokumen-1',
                'file' => 'dokumen1.pdf',
                'id_kategori' => 1,
                'download_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
