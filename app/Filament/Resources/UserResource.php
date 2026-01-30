<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Facades\Filament;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Users / Admin';

    public static function canAccess(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();
        return $user && $user->is_admin;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 🧱 Bagian Data User / Admin
                Forms\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        FileUpload::make('foto')
                            ->disk('public')
                            ->directory('users')
                            ->image()
                            ->label('Foto Profil'),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama Lengkap'),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn($record) => $record === null),

                        Forms\Components\Toggle::make('is_admin')
                            ->label('Admin?')
                            ->inline(false),
                    ]),

                // 🏠 Bagian Alamat Pelanggan
                Forms\Components\Section::make('Alamat Pengguna')
                    ->schema([
                        Forms\Components\Repeater::make('alamats')
                            ->relationship('alamats') 
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Label (Rumah, Kantor, dll)')
                                    ->required(),

                                Forms\Components\TextInput::make('nama_penerima')
                                    ->label('Nama Penerima')
                                    ->required(),

                                Forms\Components\TextInput::make('telepon_penerima')
                                    ->label('Telepon')
                                    ->required(),

                                Forms\Components\Textarea::make('alamat_lengkap')
                                    ->label('Alamat Lengkap')
                                    ->rows(2)
                                    ->required(),

                                Forms\Components\TextInput::make('kota')
                                    ->label('Kota')
                                    ->required(),

                                Forms\Components\TextInput::make('kode_pos')
                                    ->label('Kode Pos')
                                    ->numeric(),

                                Forms\Components\Toggle::make('is_default')
                                    ->label('Alamat Utama'),
                            ])
                            ->columns(2)
                            ->createItemButtonLabel('Tambah Alamat'),
                    ]),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')->square(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->label('Admin'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
