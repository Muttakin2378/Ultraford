<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;
    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';
    protected static ?string $navigationLabel = 'Transaksi';

    public static function canAccess(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();
        return $user && $user->is_admin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Transaksi')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('alamat_id')
                            ->label('Alamat Pengiriman')
                            ->options(
                                Alamat::all()->mapWithKeys(function ($alamat) {
                                    return [
                                        $alamat->id => "{$alamat->alamat_lengkap} - kota/kab {$alamat->kota} - {$alamat->kode_pos} ",
                                    ];
                                })
                            )
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $alamat = Alamat::find($state);
                                if ($alamat) {
                                    $set('nama_penerima', $alamat->nama_penerima);
                                    $set('no_telp_penerima', $alamat->telepon_penerima);
                                    $set('alamat_lengkap', $alamat->alamat_lengkap);
                                    $set('kota', $alamat->kota);
                                }
                            })
                            ->required(),

                        Forms\Components\TextInput::make('nama_penerima')
                            ->label('Nama Penerima')
                            ->dehydrated(true)
                            ->required(),

                        Forms\Components\TextInput::make('no_telp_penerima')
                            ->label('No. Telepon')
                            ->dehydrated(true)
                            ->required(),

                        DatePicker::make('tanggal_transaksi')
                            ->label('Tanggal Transaksi')
                            ->default(now())
                            ->required(),

                        Select::make('ekspedisi')
                            ->options([
                                'spx' => 'spx',
                                'jnt' => 'jnt',
                                'jne' => 'jne',
                                'sicepat' => 'sicepat',
                            ])
                            ->default('jnt')
                            ->required()
                            ->reactive(),

                        Select::make('status')
                            ->options([
                                'pending' => 'pending',
                                'dikemas' => 'dikemas',
                                'dikirim' => 'dikirim',
                                'diterima' => 'diterima',
                                'selesai' => 'selesai',
                                'dibatalkan' => 'dibatalkan',
                                'return' => 'return',
                            ])
                            ->default('pending')
                            ->required()
                            ->reactive(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Produk')
                    ->schema([
                        Repeater::make('detailTransaksis')
                            ->relationship()
                            ->label('Daftar Produk')
                            ->schema(function (callable $get, $livewire) {
                                // Deteksi jika sedang di halaman "View"
                                $isViewPage = $livewire instanceof \App\Filament\Resources\TransaksiResource\Pages\ViewTransaksi;

                                if ($isViewPage) {
                                    //  Tampilan khusus halaman View (readonly)
                                    return [
                                        Select::make('produk_id')
                                            ->label('Produk')
                                            ->options(Produk::pluck('nama_produk', 'id'))
                                            ->disabled()
                                            ->dehydrated(false),

                                        TextInput::make('jumlah')
                                            ->numeric()
                                            ->readOnly()
                                            ->label('Jumlah'),

                                        TextInput::make('harga_satuan')
                                            ->numeric()
                                            ->readOnly()
                                            ->label('Harga Satuan (Rp)'),

                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->readOnly()
                                            ->label('Subtotal (Rp)'),
                                    ];
                                }

                                //  Tampilan untuk Create/Edit seperti semula
                                return [
                                    Select::make('produk_id')
                                        ->label('Produk')
                                        ->options(function (callable $get) {
                                            $produkOptions = Produk::pluck('nama_produk', 'id')->toArray();
                                            $selected = collect($get('../../detailTransaksis'))
                                                ->pluck('produk_id')
                                                ->filter()
                                                ->toArray();

                                            return collect($produkOptions)
                                                ->reject(fn($nama, $id) => in_array($id, $selected))
                                                ->toArray();
                                        })
                                        ->searchable()
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $produk = Produk::find($state);
                                            if ($produk) {
                                                $set('harga_satuan', $produk->harga_jual);
                                                $set('stok_tersedia', $produk->stok);
                                                $set('jumlah', 1);
                                                $set('subtotal', $produk->harga_jual);
                                            }
                                        }),

                                    TextInput::make('stok_tersedia')
                                        ->label('Stok Tersedia')
                                        ->disabled()
                                        ->dehydrated(false),

                                    TextInput::make('jumlah')
                                        ->numeric()
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $stok = $get('stok_tersedia') ?? 0;
                                            $harga = $get('harga_satuan') ?? 0;

                                            if ($state > $stok) {
                                                Notification::make()
                                                    ->title('Jumlah melebihi stok yang tersedia!')
                                                    ->danger()
                                                    ->send();

                                                $set('jumlah', $stok);
                                                $set('subtotal', $stok * $harga);
                                            } else {
                                                $set('subtotal', $state * $harga);
                                            }

                                            $items = collect($get('../../detailTransaksis'));
                                            $total = $items->sum(fn($item) => ($item['subtotal'] ?? 0));
                                            $set('../../total_harga', $total);
                                        }),

                                    TextInput::make('harga_satuan')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated()
                                        ->label('Harga Satuan (Rp)'),

                                    TextInput::make('subtotal')
                                        ->numeric()
                                        ->readOnly()
                                        ->dehydrated(true)
                                        ->label('Subtotal (Rp)'),
                                ];
                            })
                            ->columns(5)
                            ->createItemButtonLabel('Tambah Produk')

                            ->afterStateUpdated(function (callable $set, callable $get) {
                                //  Update total juga setiap kali repeater berubah (misal: tambah atau hapus produk)
                                $items = collect($get('detailTransaksis'));
                                $total = $items->sum(fn($item) => ($item['subtotal'] ?? 0));
                                $set('total_harga', $total);
                            }),


                    ]),

                Forms\Components\Section::make('Total')
                    ->schema([
                        TextInput::make('total_harga')
                            ->label('Total Harga (Rp)')
                            ->numeric()
                            ->readOnly(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_transaksi', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User'),

                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Nama Penerima')
                    ->searchable(),

                Tables\Columns\TextColumn::make('no_telp_penerima')
                    ->label('No. Telepon')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_transaksi')
                    ->label('Tanggal')
                    ->date(),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR', true),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'pending',
                        'dikemas' => 'Dikemas',
                        'dikirim' => 'Dikirim',
                        'diterima' => 'Diterima',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        'return' => 'return'
                    ])
                    ->selectablePlaceholder(false) // biar tidak ada placeholder kosong
                    ->rules(['required'])
                    ->afterStateUpdated(function ($state, $record) {
                        // Optional: kirim notifikasi setelah status berubah
                        \Filament\Notifications\Notification::make()
                            ->title("Status transaksi #{$record->id} diubah menjadi {$state}")
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([
                // filter berdasarkan status
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Transaksi')
                    ->options([
                        'pending' => 'pending',
                        'dikemas' => 'Dikemas',
                        'dikirim' => 'Dikirim',
                        'diterima' => 'Diterima',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        'return' => 'return'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
            'view' => Pages\ViewTransaksi::route('/{record}'),
        ];
    }
}
