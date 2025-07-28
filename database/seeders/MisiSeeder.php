<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MisiSeeder extends Seeder
{
    public function run()
    {
        DB::table('misi')->insert([
            [
                'id_misi' => 1,
                'nomor_urut' => 1,
                'deskripsi_misi' => 'Misi 1',
                'periode_mulai' => 2021,
                'periode_selesai' => 2026,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
