<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Tables;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TransaksiTerbaru extends TableWidget
{
    protected static ?string $heading = 'Transaksi Terbaru';

    protected function getTableQuery(): Builder
    {
        return Transaksi::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('ID'),

            Tables\Columns\TextColumn::make('user.name')
                ->label('User'),

            Tables\Columns\TextColumn::make('total_harga')
                ->money('IDR', true)
                ->label('Total'),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'info' => 'dikirim',
                    'success' => 'selesai',
                    'danger' => 'dibatalkan',
                ]),

            Tables\Columns\TextColumn::make('created_at')
                ->since()
                ->label('Waktu'),
        ];
    }
}
