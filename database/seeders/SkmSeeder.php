<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkmSeeder extends Seeder
{
    public function run()
    {
        DB::table('skm')->insert([
            [
                'id' => 1,
                'nilai' => 4,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
