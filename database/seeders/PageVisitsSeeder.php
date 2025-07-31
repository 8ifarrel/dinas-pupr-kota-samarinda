<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageVisitsSeeder extends Seeder
{
    public function run()
    {
        DB::table('page_visits')->insert([
            [
                'id' => 1,
                'visitor_id' => 'visitor-1',
                'visited_page_context' => 'home',
                'visited_at' => now(),
            ],
        ]);
    }
}
