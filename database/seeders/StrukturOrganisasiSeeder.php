<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('struktur_organisasi')->insert([
            [
                'id_struktur_organisasi' => 1,
                'id_susunan_organisasi' => 2,
                'ikon_jabatan' => 'struktur-organisasi/sekretariat/ikon/sekretariat.png',
                'nomor_urut_jabatan' => 1,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 2,
                'id_susunan_organisasi' => 6,
                'ikon_jabatan' => 'struktur-organisasi/bidang-sumber-daya-air/ikon/bidang-sumber-daya-air.png',
                'nomor_urut_jabatan' => 2,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 3,
                'id_susunan_organisasi' => 7,
                'ikon_jabatan' => 'struktur-organisasi/bidang-bina-marga/ikon/bidang-bina-marga.png',
                'nomor_urut_jabatan' => 3,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 4,
                'id_susunan_organisasi' => 8,
                'ikon_jabatan' => 'struktur-organisasi/bidang-cipta-karya/ikon/bidang-cipta-karya.png',
                'nomor_urut_jabatan' => 4,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 5,
                'id_susunan_organisasi' => 9,
                'ikon_jabatan' => 'struktur-organisasi/bidang-bina-konstruksi/ikon/bidang-bina-konstruksi.png',
                'nomor_urut_jabatan' => 5,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 6,
                'id_susunan_organisasi' => 10,
                'ikon_jabatan' => 'struktur-organisasi/bidang-tata-ruang/ikon/bidang-tata-ruang.png',
                'nomor_urut_jabatan' => 6,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 7,
                'id_susunan_organisasi' => 11,
                'ikon_jabatan' => 'struktur-organisasi/bidang-pertanahan/ikon/bidang-pertanahan.png',
                'nomor_urut_jabatan' => 7,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 8,
                'id_susunan_organisasi' => 12,
                'ikon_jabatan' => 'struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/ikon/uptd-pengelolaan-air-limbah-domestik.png',
                'nomor_urut_jabatan' => 8,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 9,
                'id_susunan_organisasi' => 13,
                'ikon_jabatan' => 'struktur-organisasi/uptd-pemeliharaan-jalan-dan-jembatan/ikon/uptd-pemeliharaan-jalan-dan-jembatan.png',
                'nomor_urut_jabatan' => 9,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
            [
                'id_struktur_organisasi' => 10,
                'id_susunan_organisasi' => 14,
                'ikon_jabatan' => 'struktur-organisasi/uptd-pemeliharaan-saluran-drainase-dan-irigasi/ikon/uptd-pemeliharaan-saluran-drainase-dan-irigasi.png',
                'nomor_urut_jabatan' => 10,
                'created_at' => '2024-07-25 17:18:15',
                'updated_at' => '2024-07-25 17:18:15',
            ],
        ]);
    }
}
