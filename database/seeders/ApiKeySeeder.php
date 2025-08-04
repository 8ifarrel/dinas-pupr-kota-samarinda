<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ApiKey;
use Illuminate\Support\Str;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApiKey::create([
            'key' => 'test-api-key-12345',
            'name' => 'Test API Key',
            'is_active' => true,
            'generated_by_user_id' => 1, // Sesuaikan dengan user ID yang ada
        ]);

        ApiKey::create([
            'key' => Str::random(32),
            'name' => 'Production API Key',
            'is_active' => true,
            'generated_by_user_id' => 1,
        ]);
    }
}
