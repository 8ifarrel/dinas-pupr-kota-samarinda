<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiSliderSeeder extends Seeder
{
    public function run()
    {
        DB::table('struktur_organisasi_slider')->insert([
            [
                'id_slider' => 1,
                'id_struktur_organisasi' => 1,
                'foto' => 'struktur_slider1.jpg',
                'keterangan' => 'Keterangan slider 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
