<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnOrderResource\Pages;
use App\Models\ReturnOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;

class ReturnOrderResource extends Resource
{
    protected static ?string $model = ReturnOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationLabel = 'Return Order';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()?->is_admin === true;
    }

    public static function canCreate(): bool
    {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('user_id')
                ->label('User')
                ->disabled(),

            TextInput::make('transaksi_id')
                ->label('ID Transaksi')
                ->disabled(),

            Textarea::make('alasan')
                ->disabled()
                ->columnSpanFull(),

            FileUpload::make('foto_bukti')
                ->image()
                ->disabled(),

            TextInput::make('no_resi')
                ->disabled(),

            Select::make('status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'disetujui' => 'Disetujui',
                    'dikirim' => 'Dikirim',
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                ])
                ->required(),

            Textarea::make('catatan_admin')
                ->label('Catatan Admin')
                ->columnSpanFull(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('transaksi.id')
                    ->label('Transaksi'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('alasan')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->alasan),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'menunggu',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                        'primary' => 'diterima',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'diterima' => 'Diterima',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make()
                    ->after(function ($record) {
                        Notification::make()
                            ->title('Status return diperbarui')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReturnOrders::route('/'),
            'edit' => Pages\EditReturnOrder::route('/{record}/edit'),
            'view' => Pages\ViewReturnOrder::route('/{record}'),
        ];
    }
}
