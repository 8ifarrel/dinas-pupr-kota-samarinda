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
                'id_susunan_organisasi' => 1,
                'fullname' => 'Admin PUPR',
                'name' => 'admin',
                'email' => 'admin@pupr.go.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_super_admin' => 1,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
