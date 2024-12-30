<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateHashedPassword extends Command
{
    protected $signature = 'password:hash {password}';
    protected $description = 'Generate hashed password';

    public function handle()
    {
        $password = $this->argument('password');

        $hashedPassword = Hash::make($password);

        $this->info("Original Password: $password");
        $this->info("Hashed Password: $hashedPassword");
    }
}
