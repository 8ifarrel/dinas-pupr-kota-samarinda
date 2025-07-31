<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepalaDinasRiwayatPendidikanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kepala_dinas_riwayat_pendidikan')->insert([
            [
                'id_pendidikan' => 1,
                'id_kepala_dinas' => 1,
                'nama_pendidikan' => 'S1 Teknik Sipil',
                'tanggal_masuk' => '1990-08-01',
                'id_susunan_organisasi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
