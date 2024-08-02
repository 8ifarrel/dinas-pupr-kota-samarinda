<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$this->call([
			JabatanSeeder::class,
			UpdateJabatanParentSeeder::class,
			BeritaKategoriSeeder::class,
			BeritaSeeder::class,
			SliderSeeder::class,
			StrukturOrganisasiSeeder::class,
			PartnerSeeder::class,
			PegawaiSeeder::class,
			KepalaDinasRiwayatPendidikanSeeder::class,
			KepalaDinasJenjangKarirSeeder::class,
			SejarahKotaSamarindaSeeder::class,
			SejarahDinasPUPRKotaSamarindaSeeder::class,
			StrukturOrganisasiDiagramSeeder::class,
			VisiSeeder::class,
			MisiSeeder::class,
			PengumumanSeeder::class,
			StrukturOrganisasiSliderSeeder::class
		]);
	}
}
