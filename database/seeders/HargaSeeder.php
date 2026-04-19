<?php

namespace Database\Seeders;

use App\Models\Harga;
use Illuminate\Database\Seeder;

class HargaSeeder extends Seeder
{
    public function run(): void
    {
        Harga::truncate();

        // 1. Laundry Kiloan
        Harga::create([
            'nama_paket' => 'Laundry Kiloan',
            'estimasi'   => 'Harga Per Kilogram',
            'konten'     => [
                [
                    'nama_kategori' => 'Paket Laundry',
                    'items' => [
                        ['nama_item' => 'Reguler',      'harga_label' => 'Rp 5.000/Kg'],
                        ['nama_item' => 'Oneday',       'harga_label' => 'Rp 8.000/Kg'],
                        ['nama_item' => 'Express',      'harga_label' => 'Rp 12.000/Kg'],
                        ['nama_item' => 'Setrika Only', 'harga_label' => 'Rp 4.000/Kg'],
                        ['nama_item' => 'Cuci Only',    'harga_label' => 'Rp 4.000/Kg'],
                    ],
                ],
            ],
        ]);

        // 2. Satuan
        Harga::create([
            'nama_paket' => 'Satuan',
            'estimasi'   => 'Harga Per Satuan',
            'konten'     => [
                [
                    'nama_kategori' => 'Pakaian & Aksesoris',
                    'items' => [
                        ['nama_item' => 'Pakaian Ringan (kemeja/kaos/blouse)', 'harga_label' => 'Rp 5.000/pcs'],
                        ['nama_item' => 'Mukena (*ketebalan & bahan)',         'harga_label' => 'Rp 5.000 - 10.000/pcs'],
                        ['nama_item' => 'Jas/Blazer',                         'harga_label' => 'Rp 10.000/pcs'],
                        ['nama_item' => 'Toga',                                'harga_label' => 'Rp 10.000/pcs'],
                        ['nama_item' => 'Tas',                                 'harga_label' => 'Rp 10.000/pcs'],
                    ],
                ],
                [
                    'nama_kategori' => 'Perlengkapan Rumah',
                    'items' => [
                        ['nama_item' => 'Selimut',        'harga_label' => 'Rp 8.000/pcs'],
                        ['nama_item' => 'Sprei (*Ukuran)', 'harga_label' => 'Rp 8.000/pcs'],
                        ['nama_item' => 'Bedcover Kecil', 'harga_label' => 'Rp 15.000/pcs'],
                        ['nama_item' => 'Bedcover Besar', 'harga_label' => 'Rp 20.000/pcs'],
                    ],
                ],
                [
                    'nama_kategori' => 'Lainnya',
                    'items' => [
                        ['nama_item' => 'Sepatu (cuci easy, tapak, upper & midsole)', 'harga_label' => 'Rp 10.000/psg'],
                    ],
                ],
            ],
        ]);

    }
}
