<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        Kontak::updateOrCreate(
            ['id' => 1],
            [
                'tiktok' => 'laundry.ak',
                'whatsapp' => '628816514122',
                'instagram' => 'laundry.ak',
                'jam_operasional' => 'Setiap Hari: 07.00 - 21.00 WIB',
                'url_gmaps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26637.338274372636!2d110.39182736549081!3d-7.048708778210906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b00239a706b%3A0x358ac80b5fcf63a3!2sLAUNDRY%20AK!5e0!3m2!1sen!2sid!4v1774404115318!5m2!1sen!2sid',
            ]
        );
    }
}