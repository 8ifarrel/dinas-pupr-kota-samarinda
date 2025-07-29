<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisiSeeder extends Seeder
{
    public function run()
    {
        DB::table('visi')->insert([
            [
                'id_visi' => 1,
                'deskripsi_visi' => 'Menjadi Dinas PUPR terbaik di Indonesia',
                'periode_mulai' => 2021,
                'periode_selesai' => 2026,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
