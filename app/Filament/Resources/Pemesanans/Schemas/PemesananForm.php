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

        // Hanya auto-hitung untuk Laundry Kiloan
        if ($paket !== 'Laundry Kiloan' || !$jenisLayanan) {
            return;
        }

        $harga = \App\Models\Harga::where('nama_paket', $paket)->first();
        if (!$harga || !is_array($harga->konten)) {
            $set('total_estimasi_harga', 0);
            return;
        }

        $price = 0;
        foreach ($harga->konten as $kategori) {
            if (!isset($kategori['items']) || !is_array($kategori['items'])) continue;
            foreach ($kategori['items'] as $item) {
                if (($item['nama_item'] ?? '') === $jenisLayanan) {
                    $label = $item['harga_label'] ?? '';
                    $cleanPrice = preg_replace('/[^0-9]/', '', $label);
                    $price = (float) $cleanPrice;
                    break 2;
                }
            }
        }

        $total = $price * $berat;
        $set('total_estimasi_harga', $total);
    }

    public static function isKiloan(\Filament\Schemas\Components\Utilities\Get $get): bool
    {
        $paket = $get('paket');
        return $paket === 'Laundry Kiloan';
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_pesanan')
                    ->label('Invoice')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Otomatis (contoh: 0407.19042026.0001)')
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
                            }
                        }
                    }),
                // -------------------------------------

                TextInput::make('nama_pelanggan')->required(),
                TextInput::make('nomor_whatsapp')->required(),
                
                \Filament\Forms\Components\Select::make('paket')
                    ->options(\App\Models\Harga::pluck('nama_paket', 'nama_paket'))
                    ->live()
                    ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) {
                        $set('jenis_layanan', null);
                        $set('total_estimasi_harga', 0);
                        self::updateEstimasiHarga($set, $get);
                    })
                    ->required(),
                    
                \Filament\Forms\Components\Select::make('jenis_layanan')
                    ->options(function (\Filament\Schemas\Components\Utilities\Get $get) {
                        $paket = $get('paket');
                        if (!$paket) return [];

                        $harga = \App\Models\Harga::where('nama_paket', $paket)->first();
                        if (!$harga || !is_array($harga->konten)) return [];

                        $options = [];
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
                        return $options;
                    })
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) => self::updateEstimasiHarga($set, $get))
                    ->required(),
                    
                TextInput::make('berat')
                    ->numeric()
                    ->suffix('Kg')
                    ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => self::isKiloan($get))
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) => self::updateEstimasiHarga($set, $get))
                    ->default(null),
                    
                TextInput::make('jumlah_item')
                    ->numeric()
                    ->integer()
                    ->suffix('pcs')
                    ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => !self::isKiloan($get))
                    ->live(onBlur: true)
                    ->default(null),
                    
                TextInput::make('total_estimasi_harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->helperText(fn (\Filament\Schemas\Components\Utilities\Get $get) => 
                        self::isKiloan($get) 
                            ? 'Otomatis dihitung dari jenis layanan × berat' 
                            : 'Input manual karena harga satuan bervariasi'
                    ),
                    
                \Filament\Forms\Components\Select::make('metode_pembayaran')
                    ->options([
                        'Cash' => 'Cash',
                        'QRIS' => 'QRIS',
                    ])
                    ->required(),

                \Filament\Forms\Components\FileUpload::make('foto')
                    ->label('Foto Kondisi Awal')
                    ->image()
                    ->multiple()
                    ->maxFiles(5)
                    ->directory('foto-pemesanan')
                    ->columnSpanFull()
                    ->reorderable()
                    ->imageEditor()
                    ->helperText('Upload foto kondisi awal laundry pelanggan (maks 5 foto)'),

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
