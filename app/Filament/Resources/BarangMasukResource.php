<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangMasukResource\Pages;
use App\Filament\Resources\BarangMasukResource\RelationManagers;
use App\Models\BarangMasuk;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Facades\Filament;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationLabel = 'Barang Masuk';

    public static function canAccess(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();
        return $user && $user->is_admin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Bagian Data Utama
                Forms\Components\Section::make('Data Barang Masuk')
                    ->schema([
                        DatePicker::make('tanggal_masuk')
                            ->label('Tanggal Masuk')
                            ->default(now())
                            ->required(),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(2)
                            ->nullable(),
                    ])
                    ->columns(2),

                // Bagian Detail Produk
                Forms\Components\Section::make('Detail Produk Masuk')
                    ->schema([
                        Repeater::make('detailBarangMasuks')
                            ->relationship()
                            ->label('Daftar Barang Masuk')
                            ->schema([
                                Select::make('produk_id')
                                    ->label('Produk')
                                    ->options(Produk::pluck('nama_produk', 'id'))
                                    ->searchable()
                                    ->required(),

                                TextInput::make('jumlah')
                                    ->label('Jumlah Masuk')
                                    ->numeric()
                                    ->required()
                                    ->live() // agar realtime
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        // Hitung ulang total item setiap kali jumlah berubah
                                        $items = collect($get('../../detailBarangMasuks'));
                                        $total = $items->sum(fn($item) => (int) ($item['jumlah'] ?? 0));
                                        $set('../../total_item', $total);
                                    }),
                            ])
                            ->columns(2)
                            ->createItemButtonLabel('Tambah Barang')
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                // Hitung total item saat item ditambah/dihapus
                                $items = collect($get('detailBarangMasuks'));
                                $total = $items->sum(fn($item) => (int) ($item['jumlah'] ?? 0));
                                $set('total_item', $total);
                            }),

                        // Total Item di bawah repeater
                        TextInput::make('total_item')
                            ->label('Total Item Masuk')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(true)
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_item')
                    ->label('Total Item')
                    ->numeric(),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DetailBarangMasuksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangMasuks::route('/'),
            'create' => Pages\CreateBarangMasuk::route('/create'),
            'edit' => Pages\EditBarangMasuk::route('/{record}/edit'),
            'view' => Pages\ViewBarangMasuk::route('/{record}'),
        ];
    }
}
