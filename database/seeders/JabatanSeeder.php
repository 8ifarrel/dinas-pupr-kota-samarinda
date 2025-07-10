<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        $namaJabatan = $faker->jobTitle;
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Kepala Dinas', 
            'id_jabatan_parent' => null,
            'slug_jabatan' => Str::slug($namaJabatan),
            'tupoksi_jabatan' => $faker->sentence,
            'deskripsi_jabatan' => $faker->paragraph,
            'kelompok_jabatan' => 'Kepala Dinas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        for ($i = 1; $i <= 10; $i++) {
            $namaJabatan = $faker->jobTitle;
            DB::table('jabatan')->insert([
                'nama_jabatan' => $namaJabatan, 
                'id_jabatan_parent' => null,
                'slug_jabatan' => Str::slug($namaJabatan),
                'tupoksi_jabatan' => $faker->sentence,
                'deskripsi_jabatan' => $faker->paragraph,
                'kelompok_jabatan' => $faker->randomElement([
                                                    'Subbagian', 
                                                    'UPTD', 
                                                    'Bidang', 
                                                    'PLT', 
                                                    'Sekretariat', 
                                                    'Jabatan Fungsional'
                                                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

