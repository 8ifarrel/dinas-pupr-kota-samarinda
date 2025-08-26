<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SejarahDinasPuprKotaSamarindaSeeder extends Seeder
{
    public function run()
    {
        DB::table('sejarah_dinas_pupr_kota_samarinda')->insert([
            [
                'id_sejarah_dinas_pupr_kota_samarinda' => 1,
                'deskripsi_sejarah_dinas_pupr_kota_samarinda' => 'Sejarah singkat Dinas PUPR Kota Samarinda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
