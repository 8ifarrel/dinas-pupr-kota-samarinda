<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'id_susunan_organisasi' => null,
                'fullname' => 'Muhammad Farrel Sirah',
                'name' => '8ifarrel',
                'email' => null,
                'email_verified_at' => null,
                'password' => Hash::make('mautauaja05'),
                'is_super_admin' => 1,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
