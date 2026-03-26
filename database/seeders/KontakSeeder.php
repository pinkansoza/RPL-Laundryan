<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        Kontak::updateOrCreate(
            ['id' => 1], // Biar nggak duplikat kalau dijalankan ulang
            [
                'alamat' => 'Gg. Cempaka Sari No.39, Sekaran, Gn. Pati, Semarang',
                'whatsapp' => '628816514122',
                'instagram' => 'laundry.ak',
                'jam_operasional' => 'Setiap Hari: 07.00 - 21.00 WIB',
                'url_gmaps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.610668041535!2d110.3901!3d-7.0453!', // Ganti dengan link src asli kamu nanti
            ]
        );
    }
}