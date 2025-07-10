<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visi')->insert([
            'deskripsi_visi' => 'Menjadi kota yang berwawasan lingkungan dan berkelanjutan',
            'periode_mulai' => 2021,
            'periode_selesai' => 2026,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

