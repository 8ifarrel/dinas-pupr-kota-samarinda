<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorsSeeder extends Seeder
{
    public function run()
    {
        DB::table('visitors')->insert([
            [
                'id' => 1,
                'visitor_id' => 'visitor-1',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0',
                'first_visit_at' => now(),
            ],
        ]);
    }
}
