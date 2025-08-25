<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SejarahDinasPuprKotaSamarindaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sejarah_dinas_pupr_kota_samarinda')->insert([
            'deskripsi_sejarah_dinas_pupr_kota_samarinda' => 'Sejarah Dinas PUPR Kota Samarinda, isi sejarahnya di sini...',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
