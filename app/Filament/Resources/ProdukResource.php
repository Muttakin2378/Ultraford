<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Facades\Filament;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Produk';

    public static function canAccess(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();
        return $user && $user->is_admin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required(),

                Forms\Components\Select::make('jenis')
                    ->label('Jenis Produk')
                    ->options([
                        'semua' => 'Semua',
                        'tent' => 'Tent',
                        'sleeping_system' => 'Sleeping System',
                        'cooking_set' => 'Cooking Set',
                        'bag' => 'Bag',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('stok')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('harga_jual')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi'),

                //  Gambar utama (kolom "gambar" di tabel produks)
                FileUpload::make('gambar')
                    ->label('Gambar Utama')
                    ->disk('public')
                    ->directory('produk/utama')
                    ->image()
                    ->visibility('public')
                    ->required(),

                //  Galeri tambahan (relasi ke produk_gambars)
                Repeater::make('gambars')
                    ->label('Galeri Tambahan')
                    ->relationship('gambars') // relasi dari model Produk
                    ->schema([
                        FileUpload::make('path_gambar')
                            ->label('Gambar Tambahan')
                            ->disk('public')
                            ->directory('produk/galeri')
                            ->image()
                            ->visibility('public')
                            ->required(),
                    ])
                    ->columns(1)
                    ->collapsed() // biar tampil rapi
                    ->addActionLabel('Tambah Gambar'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar Utama')
                    ->getStateUsing(fn($record) => asset('storage/' . $record->gambar))
                    ->square()
                    ->size(80),


                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis'),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok'),

                Tables\Columns\TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'view' => Pages\ViewProduk::route('/{record}'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
