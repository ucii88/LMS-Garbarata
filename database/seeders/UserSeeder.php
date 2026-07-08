<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator LMS',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Capt. Hermawan (Instruktur)',
            'email' => 'instruktur@lms.com',
            'password' => Hash::make('password'),
            'role' => 'instruktur',
        ]);

        User::create([
            'name' => 'Budi Santoso (Peserta)',
            'email' => 'peserta@lms.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
        ]);
    }
}
