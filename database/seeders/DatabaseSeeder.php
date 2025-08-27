<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call([
			// Seeder dasar organisasi dan struktur
			SusunanOrganisasiSeeder::class,
			StrukturOrganisasiSeeder::class,
			StrukturOrganisasiDiagramSeeder::class,
			StrukturOrganisasiSliderSeeder::class,

			// Seeder kepala dinas
			KepalaDinasSeeder::class,
			KepalaDinasJenjangKarirSeeder::class,
			KepalaDinasRiwayatPendidikanSeeder::class,

			// Seeder visi dan misi
			VisiSeeder::class,
			MisiSeeder::class,
			SejarahDinasPuprKotaSamarindaSeeder::class,

			// Seeder lokasi (kecamatan dan kelurahan)
			KecamatanSeeder::class,
			KelurahanSeeder::class,

			// Seeder berita dan kategori
			BeritaKategoriSeeder::class,
			BeritaSeeder::class,
			BeritaFotoTambahanSeeder::class,

			// Seeder pengumuman
			PengumumanSeeder::class,

			// Seeder PPID
			PpidPelaksanaKategoriSeeder::class,
			PpidPelaksanaSeeder::class,

			// Seeder album dan foto kegiatan
			AlbumKegiatanSeeder::class,
			FotoKegiatanSeeder::class,

			// Seeder slider
			SliderSeeder::class,

			// Seeder partner
			PartnerSeeder::class,

			// Seeder buku tamu
			BukuTamuSeeder::class,

			// Seeder SKM (Survei Kepuasan Masyarakat)
			SkmSeeder::class,
			LayananSeeder::class,

			// Seeder users dan admin
			UsersSeeder::class,

			// Seeder statistik pengunjung
			VisitorsSeeder::class,
			PageVisitsSeeder::class,

			// Seeder HantuBanyu
			DrainaseIrigasiSeeder::class,
		]);
	}
}
