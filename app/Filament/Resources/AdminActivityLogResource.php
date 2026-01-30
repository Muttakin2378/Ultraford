<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminActivityLogResource\Pages;
use App\Filament\Resources\AdminActivityLogResource\RelationManagers;
use App\Models\AdminActivityLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminActivityLogResource extends Resource
{
    protected static ?string $model = AdminActivityLog::class;
    protected static ?string $navigationLabel = 'Log Aktivitas Admin';
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 99;
    public static function canCreate(): bool { return false; }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Admin')
                    ->searchable(),

                Tables\Columns\TextColumn::make('aksi')
                    ->badge(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(50),

                Tables\Columns\TextColumn::make('ip'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminActivityLogs::route('/'),
            'create' => Pages\CreateAdminActivityLog::route('/create'),
            'edit' => Pages\EditAdminActivityLog::route('/{record}/edit'),
        ];
    }
}
