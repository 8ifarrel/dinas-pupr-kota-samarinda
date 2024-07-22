<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UpdateJabatanParentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        DB::table('jabatan')->where('id_jabatan', 2)->update(['id_jabatan_parent' => $faker->numberBetween(1, 5)]);
        DB::table('jabatan')->where('id_jabatan', 3)->update(['id_jabatan_parent' => $faker->numberBetween(1, 5)]);
        DB::table('jabatan')->where('id_jabatan', 4)->update(['id_jabatan_parent' => $faker->numberBetween(1, 5)]);
        DB::table('jabatan')->where('id_jabatan', 5)->update(['id_jabatan_parent' => $faker->numberBetween(1, 5)]);
    }
}
