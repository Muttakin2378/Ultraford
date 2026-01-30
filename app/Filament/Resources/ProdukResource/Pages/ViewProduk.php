<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use App\Filament\Resources\ProdukResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;

class ViewProduk extends ViewRecord
{
    protected static string $resource = ProdukResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Section::make('Gambar Utama')
                ->schema([
                    ImageEntry::make('gambar')
                        ->label('')
                        ->getStateUsing(fn($record) =>
                            $record->gambar
                                ? asset('storage/' . $record->gambar)
                                : null
                        )
                        ->height(250)
                        ->columnSpanFull(),
                ])
                ->collapsible(),

            Section::make('Informasi Produk')
                ->schema([
                    TextEntry::make('nama_produk')->label('Nama Produk'),
                    TextEntry::make('jenis')->label('Jenis Produk'),
                    TextEntry::make('stok')->label('Stok'),
                    TextEntry::make('harga_jual')->label('Harga Jual')->money('IDR'),
                    TextEntry::make('deskripsi')->label('Deskripsi')->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),

            
        ]);
    }
}
