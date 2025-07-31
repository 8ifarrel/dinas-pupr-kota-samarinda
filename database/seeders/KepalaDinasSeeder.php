<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepalaDinasSeeder extends Seeder
{
    public function run()
    {
        DB::table('kepala_dinas')->insert([
            [
                'id' => 1,
                'nama' => 'Desy Damayanti, S.T., M.T.',
                'foto' => 'kepala-dinas/desy-damayanti-st-mt.png',
                'nip' => '0000',
                'nomor_telepon' => '000000',
                'golongan' => 'I/a',
                'tahun_mulai' => '2021',
                'tahun_selesai' => '2026',
                'id_susunan_organisasi' => 1,
                'created_at' => '2025-06-29 11:12:08',
                'updated_at' => '2025-06-29 11:12:08',
            ],
        ]);
    }
}
