<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin (Biar bisa login Filament)
        User::create([
            'name' => 'Admin Laundry AK',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // 2. INI KUNCINYA: Panggil Seeder Beranda kamu!
        $this->call([
            BerandaSettingSeeder::class,
        ]);

        $this->call([
        KontakSeeder::class,
    ]);
    }
}