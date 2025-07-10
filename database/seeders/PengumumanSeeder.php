<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class PengumumanSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker::create();

		for ($i = 0; $i < 30; $i++) {
			$judul = $faker->sentence;

			Pengumuman::create([
				'judul_pengumuman' => $judul,
				'slug_pengumuman' => Str::slug($judul),
				'perihal' => $faker->paragraph,
				'file_lampiran' => $faker->filePath(),
			]);
		}
	}
}

