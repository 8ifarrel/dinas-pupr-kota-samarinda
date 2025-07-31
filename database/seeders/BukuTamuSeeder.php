<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuTamuSeeder extends Seeder
{
    public function run()
    {
        DB::table('buku_tamu')->insert([
            [
                'id_buku_tamu' => 'BTM001',
                'nama_pengunjung' => 'Andi',
                'nomor_telepon' => '08123456789',
                'email' => 'andi@example.com',
                'alamat' => 'Jl. Mawar No. 1',
                'jabatan_yang_dikunjungi' => 1,
                'maksud_dan_tujuan' => 'Konsultasi proyek',
                'status' => 'Pending',
                'deskripsi_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
