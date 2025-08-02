<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JalanPeduliStatus;

class JalanPeduliStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statusList = [
            'pending',
            'disposisi',
            'telah_disurvei',
            'sedang_dikerjakan',
            'telah_dikerjakan',
            'reject',
            'belum_dikerjakan'
        ];

        foreach ($statusList as $status) {
            JalanPeduliStatus::create(['nama_status' => $status]);
        }
    }
}
