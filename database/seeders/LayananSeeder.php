<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 1, 'nama' => 'gistaru',                 'struktur_organisasi_id' => 6],
            ['id' => 2, 'nama' => 'sijakon',                 'struktur_organisasi_id' => 5],
            ['id' => 3, 'nama' => 'jalan_peduli',            'struktur_organisasi_id' => 9],
            ['id' => 4, 'nama' => 'buku_tamu',               'struktur_organisasi_id' => null],
            ['id' => 5, 'nama' => 'drainase_dan_irigasi',    'struktur_organisasi_id' => 10],
            ['id' => 6, 'nama' => 'sedot_tinja',             'struktur_organisasi_id' => 8],
        ];

        foreach ($data as $layanan) {
            Layanan::updateOrCreate(
                ['id' => $layanan['id']],
                $layanan
            );
        }
    }
}
