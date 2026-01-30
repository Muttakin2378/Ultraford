<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransaksiStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transaksi', Transaksi::count())
                ->description('Semua transaksi')
                ->color('primary'),

            Stat::make(
                'Omzet',
                'Rp ' . number_format(Transaksi::where('status', 'selesai')->sum('total_harga'))
            )
                ->description('Transaksi selesai')
                ->color('success'),

            Stat::make(
                'Hari Ini',
                Transaksi::whereDate('created_at', today())->count()
            )
                ->description('Transaksi hari ini')
                ->color('info'),

            Stat::make(
                'Pending',
                Transaksi::where('status', 'pending')->count()
            )
                ->color('warning'),
        ];
    }
}
