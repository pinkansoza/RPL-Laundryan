<?php

namespace App\Filament\Resources\Pemesanans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PemesananForm
{
    public static function updateEstimasiHarga(\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get)
    {
        $paket = $get('paket');
        $jenisLayanan = $get('jenis_layanan');
        $berat = (float) $get('berat');
        $jumlah = (float) $get('jumlah_item');

        if (!$paket || !$jenisLayanan) {
            $set('total_estimasi_harga', 0);
            return;
        }

        $harga = \App\Models\Harga::where('nama_paket', $paket)->first();
        if (!$harga || !is_array($harga->konten)) {
            $set('total_estimasi_harga', 0);
            return;
        }

        $price = 0;
        $isKiloan = false;
        foreach ($harga->konten as $kategori) {
            if (!isset($kategori['items']) || !is_array($kategori['items'])) continue;
            foreach ($kategori['items'] as $item) {
                if (($item['nama_item'] ?? '') === $jenisLayanan) {
                    $label = $item['harga_label'] ?? '';
                    $cleanPrice = preg_replace('/[^0-9]/', '', $label);
                    $price = (float) $cleanPrice;
                    $isKiloan = (stripos($kategori['nama_kategori'] ?? '', 'kiloan') !== false || stripos($label, '/kg') !== false);
                    break 2;
                }
            }
        }

        $total = $isKiloan ? ($price * $berat) : ($price * ($jumlah > 0 ? $jumlah : 1));
        $set('total_estimasi_harga', $total);
    }

    public static function isKiloan(\Filament\Schemas\Components\Utilities\Get $get): bool
    {
        $jenisLayanan = $get('jenis_layanan');
        if (!$jenisLayanan) return true;

        $paket = $get('paket');
        if (!$paket) $paket = 'REGULER'; 

        $harga = \App\Models\Harga::where('nama_paket', $paket)->first() ?? \App\Models\Harga::first();
        if (!$harga || !is_array($harga->konten)) return true;

        foreach ($harga->konten as $kategori) {
            if (!isset($kategori['items']) || !is_array($kategori['items'])) continue;
            foreach ($kategori['items'] as $item) {
                if (($item['nama_item'] ?? '') === $jenisLayanan) {
                    $label = $item['harga_label'] ?? '';
                    return (stripos($kategori['nama_kategori'] ?? '', 'kiloan') !== false || stripos($label, '/kg') !== false);
                }
            }
        }
        return true;
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_pesanan')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Otomatis LDR-XXXXX')
                    ->maxLength(255),
                    
                // --- INI FITUR MAGIC AUTO-FILL NYA ---
                \Filament\Forms\Components\Select::make('cari_pelanggan')
                    ->label('🔍 Cari Pelanggan Lama (Opsional)')
                    ->options(\App\Models\Pelanggan::pluck('nama', 'id'))
                    ->searchable()
                    ->live()
                    ->dehydrated(false) // Mencegah error database karena ini bukan kolom asli pemesanan
                    ->columnSpanFull()
                    ->afterStateUpdated(function ($state, \Filament\Schemas\Components\Utilities\Set $set) {
                        if ($state) {
                            $pelanggan = \App\Models\Pelanggan::find($state);
                            if ($pelanggan) {
                                // Auto-fill data identitas
                                $set('nama_pelanggan', $pelanggan->nama);
                                $set('nomor_whatsapp', $pelanggan->nomor_whatsapp);
                                
                                // Auto-fill data lokasi
                                $set('detail_alamat', $pelanggan->detail_alamat);
                                if ($pelanggan->pickup_lat && $pelanggan->pickup_lng) {
                                    $set('pickup_lat', $pelanggan->pickup_lat);
                                    $set('pickup_lng', $pelanggan->pickup_lng);
                                    $set('titik_pickup', [
                                        'lat' => $pelanggan->pickup_lat,
                                        'lng' => $pelanggan->pickup_lng,
                                    ]);
                                }
                            }
                        }
                    }),
                // -------------------------------------

                TextInput::make('nama_pelanggan')->required(),
                TextInput::make('nomor_whatsapp')->required(),
                
                \Filament\Forms\Components\Select::make('paket')
                    ->options(\App\Models\Harga::pluck('nama_paket', 'nama_paket'))
                    ->live()
                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) => self::updateEstimasiHarga($set, $get))
                    ->required(),
                    
                \Filament\Forms\Components\Select::make('jenis_layanan')
                    ->options(function () {
                        $options = [];
                        $harga = \App\Models\Harga::first();
                        if ($harga && is_array($harga->konten)) {
                            foreach ($harga->konten as $kategori) {
                                $kategoriOptions = [];
                                if (isset($kategori['items']) && is_array($kategori['items'])) {
                                    foreach ($kategori['items'] as $item) {
                                        if (isset($item['nama_item'])) {
                                            $kategoriOptions[$item['nama_item']] = $item['nama_item'];
                                        }
                                    }
                                }
                                if (isset($kategori['nama_kategori']) && !empty($kategoriOptions)) {
                                    $options[$kategori['nama_kategori']] = $kategoriOptions;
                                }
                            }
                        }
                        return $options;
                    })
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) => self::updateEstimasiHarga($set, $get))
                    ->required(),
                    
                TextInput::make('berat')
                    ->numeric()
                    ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => self::isKiloan($get))
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) => self::updateEstimasiHarga($set, $get))
                    ->default(null),
                    
                TextInput::make('jumlah_item')
                    ->numeric()
                    ->integer()
                    ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => !self::isKiloan($get))
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) => self::updateEstimasiHarga($set, $get))
                    ->default(null),
                    
                TextInput::make('total_estimasi_harga')
                    ->required()
                    ->numeric(),
                    
                \Filament\Forms\Components\Select::make('metode_pembayaran')
                    ->options([
                        'Cash' => 'Cash',
                        'QRIS' => 'QRIS',
                    ])
                    ->required(),

                \Filament\Forms\Components\Select::make('metode_pengiriman')
                    ->label('Kirim (Pakaian Kotor)')
                    ->options([
                        'Antar Sendiri' => 'Pelanggan Antar Sendiri',
                        'Pickup' => 'Kurir Menjemput (Pickup)',
                    ])
                    ->live()
                    ->required(),

                \Filament\Forms\Components\Select::make('metode_pengambilan')
                    ->label('Ambil (Pakaian Bersih)')
                    ->options([
                        'Ambil Sendiri' => 'Pelanggan Ambil Sendiri',
                        'Diantar Laundry' => 'Kurir Mengantar',
                    ])
                    ->live()
                    ->required(),

                \Filament\Forms\Components\Select::make('jam_pickup')
                    ->options(function () {
                        $kontak = \App\Models\Kontak::first();
                        $jams = $kontak ? $kontak->jam_pickup : [];
                        if (is_array($jams) && count($jams) > 0) {
                            return array_combine($jams, $jams);
                        }
                        return [];
                    })
                    ->visible(function (\Filament\Schemas\Components\Utilities\Get $get) {
                        $kirim = $get('metode_pengiriman') ?? '';
                        $ambil = $get('metode_pengambilan') ?? '';
                        return str_contains($kirim, 'Pickup') || str_contains($ambil, 'Diantar');
                    })
                    ->default(null),

                \Dotswan\MapPicker\Fields\Map::make('titik_pickup')
                    ->label('Titik Pickup')
                    ->columnSpanFull()
                    ->defaultLocation(latitude: -6.200000, longitude: 106.816666)
                    ->afterStateHydrated(function ($state, $record, callable $set) {
                        if ($record && $record->pickup_lat && $record->pickup_lng) {
                            $set('titik_pickup', ['lat' => $record->pickup_lat, 'lng' => $record->pickup_lng]);
                        }
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (is_array($state)) {
                            $set('pickup_lat', $state['lat'] ?? null);
                            $set('pickup_lng', $state['lng'] ?? null);
                        }
                    })
                    ->live(onBlur: true)
                    ->showMarker(true)
                    ->draggable(true)
                    ->clickable(true)
                    ->showFullscreenControl(true)
                    ->showZoomControl(true)
                    ->showMyLocationButton(true)
                    ->visible(function (\Filament\Schemas\Components\Utilities\Get $get) {
                        $kirim = $get('metode_pengiriman') ?? '';
                        $ambil = $get('metode_pengambilan') ?? '';
                        return str_contains($kirim, 'Pickup') || str_contains($ambil, 'Diantar');
                    }),

                \Filament\Forms\Components\Hidden::make('pickup_lat'),
                \Filament\Forms\Components\Hidden::make('pickup_lng'),

                Textarea::make('detail_alamat')
                    ->visible(function (\Filament\Schemas\Components\Utilities\Get $get) {
                        $kirim = $get('metode_pengiriman') ?? '';
                        $ambil = $get('metode_pengambilan') ?? '';
                        return str_contains($kirim, 'Pickup') || str_contains($ambil, 'Diantar');
                    })
                    ->default(null)
                    ->columnSpanFull(),

                Textarea::make('catatan')
                    ->default(null)
                    ->columnSpanFull(),
                    
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'Diterima' => 'Diterima',
                        'Dicuci' => 'Dicuci',
                        'Selesai' => 'Selesai',
                        'Diambil' => 'Diambil',
                    ])
                    ->required()
                    ->default('Diterima'),
            ]);
    }
}