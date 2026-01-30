<?php

namespace App\Filament\Resources\BarangMasukResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DetailBarangMasuksRelationManager extends RelationManager
{
    protected static string $relationship = 'detailBarangMasuks';
    protected static ?string $title = 'Detail Barang Masuk';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah Masuk')
                    ->sortable(),
            ])
            ->headerActions([]) // Tidak perlu tambah/edit di view
            ->actions([])       // Hanya tampil, tidak bisa edit di sini
            ->paginated(false); // Tampilkan semua
    }
}
