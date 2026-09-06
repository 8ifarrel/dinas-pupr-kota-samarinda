<?php

namespace Database\Seeders;

use App\Models\JalanPeduliPelapor;
use Illuminate\Database\Seeder;

class JalanPeduliPelaporSeeder extends Seeder
{
    public function run(): void
    {
        $pelaporData = [
            [
                'nama_lengkap' => 'Andi Setiawan',
                'nomor_ponsel' => '081234567891',
                'email' => 'andi@example.com',
                'alamat_pelapor' => 'Jl. Manggis No. 10, RT 01 RW 02, Harapan Baru, Samarinda Seberang, Kota Samarinda', // <--- BARU: Alamat Pelapor
                'kecamatan_id' => 3139, // Loa Janan Ilir (contoh ID)
                'kelurahan_id' => 44461, // Harapan Baru (contoh ID)
                'rt' => '003',
            ],
            [
                'nama_lengkap' => 'Budi Hartono',
                'nomor_ponsel' => '081234567892',
                'email' => 'budi@example.com',
                'alamat_pelapor' => 'Perumahan Indah Blok C No. 5, RT 03 RW 04, Teluk Lerong Ilir, Samarinda Ulu, Kota Samarinda', // <--- BARU: Alamat Pelapor
                'kecamatan_id' => 3140, // Samarinda Ulu (contoh ID)
                'kelurahan_id' => 44462, // Teluk Lerong Ilir (contoh ID)
                'rt' => '003', // Teluk Lerong Ilir (contoh ID)
            ],
            [
                'nama_lengkap' => 'Citra Dewi',
                'nomor_ponsel' => '081234567893',
                'email' => 'citra@example.com',
                'alamat_pelapor' => 'Gang Amanah No. 12, RT 05 RW 01, Sungai Pinang Dalam, Sungai Pinang, Kota Samarinda', // <--- BARU: Alamat Pelapor
                'kecamatan_id' => 3141, // Sungai Pinang (contoh ID)
                'kelurahan_id' => 44463, // Sungai Pinang Dalam (contoh ID)
                'rt' => '003',
            ],
            [
                'nama_lengkap' => 'Deni Prasetyo',
                'nomor_ponsel' => '081234567894',
                'email' => 'deni@example.com',
                'alamat_pelapor' => 'Jl. Cendana Raya No. 8, RT 02 RW 03, Lok Bahu, Sungai Kunjang, Kota Samarinda', // <--- BARU: Alamat Pelapor
                'kecamatan_id' => 3142, // Sungai Kunjang (contoh ID)
                'kelurahan_id' => 44464, // Lok Bahu (contoh ID)
                'rt' => '003',
            ],
        ];

        foreach ($pelaporData as $data) {
            JalanPeduliPelapor::create($data);
        }
    }
}