<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BerandaSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BerandaSetting::create([
            'judul' => 'Solusi Cerdas untuk <br> <span>Pakaian Berkualitas</span>',
            'slogan' => 'Bisa antar jemput radius 3 km dari Laundry AK.',
            'gambar' => null, // Biarkan kosong dulu
        ]);
    }
}
