<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        Pegawai::create([
            'id_jabatan' => 1,
            'nama_pegawai' => $faker->name(),
            'foto_pegawai' => $faker->imageUrl(),
            'nomor_induk_pegawai' => $faker->unique()->randomNumber(5, true),
            'nomor_telepon_pegawai' => $faker->unique()->phoneNumber(),
            'golongan_pegawai' => $faker->randomElement(['I', 'II', 'III', 'IV']),
        ]);

        foreach (range(1, 50) as $index) {
            Pegawai::create([
                'id_jabatan' => $faker->numberBetween(2, 11),
                'nama_pegawai' => $faker->name(),
                'foto_pegawai' => $faker->imageUrl(),
                'nomor_induk_pegawai' => $faker->unique()->randomNumber(5, true),
                'nomor_telepon_pegawai' => $faker->unique()->phoneNumber(),
                'golongan_pegawai' => $faker->randomElement(['I', 'II', 'III', 'IV']),
            ]);
        }
    }
}

