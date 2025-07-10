<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KepalaDinasJenjangKarir;
use App\Models\Pegawai;
use Faker\Factory as Faker;

class KepalaDinasJenjangKarirSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker::create();
		$pegawaiKepalaDinas = Pegawai::whereHas('jabatan', function ($query) {
			$query->where('nama_jabatan', 'Kepala Dinas');
		})->get();

		foreach ($pegawaiKepalaDinas as $pegawai) {
			for ($i = 0; $i < 5; $i++) {
				KepalaDinasJenjangKarir::create([
					'nama_karir' => $faker->sentence($nbWords = 9, $variableNbWords = true),
					'tanggal_masuk' => $faker->date,
					'id_pegawai' => $pegawai->id_pegawai,
				]);
			}
		}
	}
}

