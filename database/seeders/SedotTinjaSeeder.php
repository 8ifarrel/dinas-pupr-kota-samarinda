<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedotTinjaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sedot_tinja')->insert([
            [
                'nama_pelanggan' => 'Budi Santoso',
                'nomor_telepon_pelanggan' => '081234567890',
                'alamat' => 'Jl. Mawar No.10, Samarinda',
                'alamat_detail' => 'Dekat Warung Bu Siti',
                'layanan' => 'Sedot WC Rumah',
                'detail_laporan' => 'WC mampet dan penuh',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => 'Samarinda Ulu',
                'kelurahan_id' => 'Air Putih',
                'latitude' => -0.502,
                'longitude' => 117.153,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 10,
                'rt' => 5,
                'rating' => 4,
                'kritik' => 'Pelayanan agak lambat',
                'saran' => 'Tolong ditambah armada',
                'captcha' => null,
                'status_pengerjaan' => 'Belum dikerjakan',
                'setuju' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pelanggan' => 'Siti Aminah',
                'nomor_telepon_pelanggan' => '082134567891',
                'alamat' => 'Jl. Melati No.25, Samarinda',
                'alamat_detail' => 'Samping Indomaret',
                'layanan' => 'Sedot WC Kantor',
                'detail_laporan' => 'Septic tank sudah penuh',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => 'Samarinda Ilir',
                'kelurahan_id' => 'Sidodadi',
                'latitude' => -0.503,
                'longitude' => 117.154,
                'jenis_bangunan' => 'Kantor',
                'nomor_bangunan' => 25,
                'rt' => 2,
                'rating' => 5,
                'kritik' => null,
                'saran' => 'Bagus, cepat selesai',
                'captcha' => null,
                'status_pengerjaan' => 'Sudah dikerjakan',
                'setuju' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
