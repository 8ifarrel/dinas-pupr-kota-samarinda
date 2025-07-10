<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasiDiagram;
use Faker\Factory as Faker;

class StrukturOrganisasiDiagramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

		StrukturOrganisasiDiagram::create([
            'diagram_struktur_organisasi' => 'https://pupr.samarindakota.go.id/storage/Profil/struktur-organisasi/struktur-organisasi.png'
        ]);
    }
}

