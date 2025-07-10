<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SejarahDinasPUPRKotaSamarinda;
use Faker\Factory as Faker;

class SejarahDinasPUPRKotaSamarindaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

		SejarahDinasPUPRKotaSamarinda::create([
			'deskripsi_sejarah_dinas_pupr_kota_samarinda' => '<p>Kantor Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda beralamat di Jalan H. Achmad Amins, Kelurahan Gunung Lingai, Kecamatan Sungai Pinang, Kota Samarinda. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda semula berada di Komplek Balaikota Samarinda yang terletak di Jl. Kesuma Bangsa No.84, Kel. Bugis, Kec. Samarinda Kota, Kota Samarinda yang sekarang digunakan sebagai Kantor Diskominfo Kota Samarinda. Pada tahun 2018, Kantor Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda dipindah ketempat yang sekarang.</p><p>Selanjutnya, pada tahun 2016 terbitlah Peraturan Daerah (PERDA) Kota Samarinda Nomor 4 Tahun 2016 pada tanggal 16 Agustus 2016 Tentang Pembentukan dan Susunan Perangkat Daerah yang dimana Dinas Pekerjaan Umum dan Penataan Ruang termasuk salah satu OPD dengan tipe A. Kemudian, pada tanggal 20 Oktober 2016 terbitlah Peraturan Walikota (PERWALI) Kota Samarinda Nomor 25 tahun 2016 Tentang Susunan Organisasi dan Tata Kerja Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Kota Samarinda. Dan terbentuknya Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda adalah gabungan dari 2 (dua) Dinas, yaitu (1) Dinas Bina Marga dan Pengairan dan (2) Dinas Cipta Karya dan Tata Kota.</p><p>Berdasarkan Peraturan Wali Kota Samarinda Nomor 106 Tahun 2021 Tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi, Serta Tata Kerja Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda pada tanggal 31 Desember 2021 yang susunan organisasi Dinas terdiri atas a. Dinas, b. Sekretariat, c. Bidang Bina Marga, d. Bidang Sumber Daya Air, e. Bidang Cipta Karya, f. Bidang Penataan Ruang, g. Bidang Bina Konstruksi, h. Bidang Pertanahan, i. UPTD Pengelolaan Air Limbah Domestik, j. UPTD Pemeliharaan Jalan dan Jembatan, k. Pemeliharaan Saluran Drainase dan Irigasi.</p>',
		]);
    }
}



