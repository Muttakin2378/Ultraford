<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Transaksi 7 Hari Terakhir';

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($day) {
            return Transaksi::whereDate('created_at', now()->subDays($day))->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $data,
                ],
            ],
            'labels' => collect(range(6, 0))->map(fn ($day) =>
                now()->subDays($day)->format('d M')
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
