<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run()
    {
        DB::table('partner')->insert([
            [
                'id_partner' => 1,
                'foto_partner' => 'partner1.png',
                'nama_partner' => 'PT Mitra Karya',
                'url_partner' => 'https://mitrakarya.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
