<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaKategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('berita_kategori')->insert([
            [
                'id_berita_kategori' => 14,
                'id_susunan_organisasi' => 10,
                'ikon_berita_kategori' => "Berita/ikon/bidang-tata-ruang.png\n",
                'created_at' => '2024-07-25 02:55:50',
                'updated_at' => '2024-07-25 02:55:50',
            ],
            [
                'id_berita_kategori' => 17,
                'id_susunan_organisasi' => 7,
                'ikon_berita_kategori' => "Berita/ikon/bidang-bina-marga.png\n",
                'created_at' => '2024-07-23 19:52:49',
                'updated_at' => '2024-07-23 19:52:49',
            ],
            [
                'id_berita_kategori' => 19,
                'id_susunan_organisasi' => 8,
                'ikon_berita_kategori' => "Berita/ikon/bidang-cipta-karya.png\n",
                'created_at' => '2024-07-23 19:52:49',
                'updated_at' => '2024-07-23 19:52:49',
            ],
            [
                'id_berita_kategori' => 20,
                'id_susunan_organisasi' => 6,
                'ikon_berita_kategori' => "Berita/ikon/bidang-sumber-daya-air.png\n",
                'created_at' => '2024-07-23 19:52:49',
                'updated_at' => '2024-07-23 19:52:49',
            ],
            [
                'id_berita_kategori' => 21,
                'id_susunan_organisasi' => 9,
                'ikon_berita_kategori' => "Berita/ikon/bidang-bina-konstruksi.png\n",
                'created_at' => '2024-07-23 19:52:50',
                'updated_at' => '2024-07-23 19:52:50',
            ],
            [
                'id_berita_kategori' => 22,
                'id_susunan_organisasi' => 12,
                'ikon_berita_kategori' => "Berita/ikon/uptd-pengelolaan-air-limbah-domestik.png\n",
                'created_at' => '2024-07-25 02:56:40',
                'updated_at' => '2024-07-25 02:56:40',
            ],
            [
                'id_berita_kategori' => 24,
                'id_susunan_organisasi' => 2,
                'ikon_berita_kategori' => 'Berita/ikon/sekretariat.png',
                'created_at' => '2024-07-23 19:52:49',
                'updated_at' => '2025-01-07 21:36:06',
            ],
            [
                'id_berita_kategori' => 25,
                'id_susunan_organisasi' => 11,
                'ikon_berita_kategori' => "Berita/ikon/bidang-pertanahan.png\n",
                'created_at' => '2024-07-25 02:55:50',
                'updated_at' => '2024-07-25 02:55:50',
            ],
            [
                'id_berita_kategori' => 26,
                'id_susunan_organisasi' => 13,
                'ikon_berita_kategori' => "Berita/ikon/uptd-pemeliharaan-jalan-dan-jembatan.png\n",
                'created_at' => '2024-07-25 02:57:16',
                'updated_at' => '2024-07-25 02:57:16',
            ],
            [
                'id_berita_kategori' => 27,
                'id_susunan_organisasi' => 14,
                'ikon_berita_kategori' => "Berita/ikon/uptd-pemeliharaan-saluran-drainase-dan-irigasi.png\n",
                'created_at' => '2024-07-25 02:57:16',
                'updated_at' => '2024-07-25 02:57:16',
            ],
        ]);
    }
}
