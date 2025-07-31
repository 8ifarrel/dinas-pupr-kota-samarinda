<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SusunanOrganisasiSeeder::class,
            BeritaKategoriSeeder::class,
            BeritaSeeder::class,
            BeritaFotoTambahanSeeder::class,
            BukuTamuSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            KepalaDinasSeeder::class,
            KepalaDinasJenjangKarirSeeder::class,
            KepalaDinasRiwayatPendidikanSeeder::class,
            AlbumKegiatanSeeder::class,
            FotoKegiatanSeeder::class,
            SliderSeeder::class,
            StrukturOrganisasiSeeder::class,
            StrukturOrganisasiDiagramSeeder::class,
            StrukturOrganisasiSliderSeeder::class,
            MisiSeeder::class,
            VisiSeeder::class,
            PengumumanSeeder::class,
            PartnerSeeder::class,
            PpidPelaksanaKategoriSeeder::class,
            PpidPelaksanaSeeder::class,
            UsersSeeder::class,
            VisitorsSeeder::class,
            PageVisitsSeeder::class,
            SkmSeeder::class,
            SejarahDinasPuprKotaSamarindaSeeder::class,
            // Seeder untuk tabel lain jika ada
        ]);
    }
}
