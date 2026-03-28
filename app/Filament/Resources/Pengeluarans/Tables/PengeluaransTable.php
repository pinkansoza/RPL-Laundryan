<?php

namespace App\Filament\Resources\Pengeluarans\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker; // Gunakan Schema untuk filter di v4
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class PengeluaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable()
                    ->wrap(), // Agar teks panjang gak kepotong

                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable()
                    // Menampilkan total pengeluaran di bawah tabel
                    ->summarize(Sum::make()->label('Total')->money('IDR')),
            ])
            ->defaultSort('tanggal', 'desc') // Urutan terbaru di paling atas
            ->filters([
                // Filter berdasarkan rentang tanggal pengeluaran
                Filter::make('tanggal')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn($q) => $q->whereDate('tanggal', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn($q) => $q->whereDate('tanggal', '<=', $data['sampai_tanggal']));
                    })
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([ // Standar v4 gunakan bulkActions untuk hapus massal
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}