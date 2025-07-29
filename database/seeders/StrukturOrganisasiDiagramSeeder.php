<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiDiagramSeeder extends Seeder
{
    public function run()
    {
        DB::table('struktur_organisasi_diagram')->insert([
            [
                'id_struktur_organisasi_diagram' => 1,
                'id_struktur_organisasi' => null,
                'diagram_struktur_organisasi' => 'struktur-organisasi/keseluruhan/diagram/dinas-pupr-kota-samarinda.png',
                'created_at' => '2024-08-02 07:03:29',
                'updated_at' => '2024-08-02 07:03:29',
            ],
            [
                'id_struktur_organisasi_diagram' => 2,
                'id_struktur_organisasi' => 1,
                'diagram_struktur_organisasi' => 'struktur-organisasi/sekretariat/diagram/sekretariat.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 3,
                'id_struktur_organisasi' => 2,
                'diagram_struktur_organisasi' => 'struktur-organisasi/bidang-sumber-daya-air/diagram/bidang-sumber-daya-air.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 4,
                'id_struktur_organisasi' => 3,
                'diagram_struktur_organisasi' => 'struktur-organisasi/bidang-bina-marga/diagram/bidang-bina-marga.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 5,
                'id_struktur_organisasi' => 4,
                'diagram_struktur_organisasi' => 'struktur-organisasi/bidang-cipta-karya/diagram/bidang-cipta-karya.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 6,
                'id_struktur_organisasi' => 5,
                'diagram_struktur_organisasi' => 'struktur-organisasi/bidang-bina-konstruksi/diagram/bidang-bina-konstruksi.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 7,
                'id_struktur_organisasi' => 6,
                'diagram_struktur_organisasi' => 'struktur-organisasi/bidang-tata-ruang/diagram/bidang-tata-ruang.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 8,
                'id_struktur_organisasi' => 7,
                'diagram_struktur_organisasi' => 'struktur-organisasi/bidang-pertanahan/diagram/bidang-pertanahan.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 9,
                'id_struktur_organisasi' => 8,
                'diagram_struktur_organisasi' => 'struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/diagram/uptd-pengelolaan-air-limbah-domestik.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 10,
                'id_struktur_organisasi' => 9,
                'diagram_struktur_organisasi' => 'struktur-organisasi/uptd-pemeliharaan-jalan-dan-jembatan/diagram/uptd-pemeliharaan-jalan-dan-jembatan.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
            [
                'id_struktur_organisasi_diagram' => 11,
                'id_struktur_organisasi' => 10,
                'diagram_struktur_organisasi' => 'struktur-organisasi/uptd-pemeliharaan-saluran-drainase-dan-irigasi/diagram/uptd-pemeliharaan-saluran-drainase-dan-irigasi.png',
                'created_at' => '2024-12-10 17:57:52',
                'updated_at' => '2024-12-10 17:57:52',
            ],
        ]);
    }
}
