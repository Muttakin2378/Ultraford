<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            // 📌 IDENTITAS PENGGUNA
            Section::make('Informasi Pengguna')
                ->schema([
                    ImageEntry::make('foto')
                        ->getStateUsing(fn($record) => $record->foto ? asset('storage/' . $record->foto) : null)
                        ->height(120)
                        ->width(120),

                    TextEntry::make('name'),

                    TextEntry::make('email'),

                    TextEntry::make('is_admin')
                        ->formatStateUsing(fn($state) => $state ? 'Admin' : 'User'),
                ])
                ->columns(2),

            // 📌 DAFTAR ALAMAT
            Section::make('Daftar Alamat')
                ->schema([
                    RepeatableEntry::make('alamats')
                        ->schema([
                            TextEntry::make('label')->label('Label'),
                            TextEntry::make('nama_penerima')->label('Nama Penerima'),
                            TextEntry::make('telepon_penerima')->label('Telepon'),
                            TextEntry::make('alamat_lengkap')->label('Alamat Lengkap'),
                            TextEntry::make('kota')->label('Kota'),
                            TextEntry::make('kode_pos')->label('Kode Pos'),
                            TextEntry::make('is_default')
                                ->label('Utama')
                                ->formatStateUsing(fn($state) => $state ? 'Ya (Default)' : '-'),
                        ])
                        ->columns(2)
                        ->label('Alamat'),
                ]),

            // 📌 RIWAYAT TRANSAKSI
            Section::make('Riwayat Transaksi')
                ->schema([
                    RepeatableEntry::make('transaksis')
                        ->schema([
                            TextEntry::make('id')
                                ->label('ID Transaksi'),

                            TextEntry::make('status')
                                ->label('Status'),

                            TextEntry::make('total_harga')
                                ->label('Total')
                                ->money('IDR'),

                            TextEntry::make('created_at')
                                ->label('Tanggal')
                                ->date(),
                        ])
                        ->columns(2)
                        ->label('Transaksi'),
                ]),


        ]);
    }
}
