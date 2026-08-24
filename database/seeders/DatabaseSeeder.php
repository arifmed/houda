<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'ARIF MOHAMMED',
            'email' => 'arifmed2@gmail.com',
            'password' => Hash::make('Arifmed@1989'),
            'role' => 'admin',
        ]);
    }
}