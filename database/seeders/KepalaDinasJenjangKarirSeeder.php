<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepalaDinasJenjangKarirSeeder extends Seeder
{
    public function run()
    {
        DB::table('kepala_dinas_jenjang_karir')->insert([
            [
                'id_karir' => 1,
                'id_kepala_dinas' => 1,
                'nama_karir' => 'Staf',
                'tanggal_masuk' => '2010-01-01',
                'id_susunan_organisasi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
