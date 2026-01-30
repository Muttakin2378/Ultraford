<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class LaporanTransaksi extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Transaksi';
    protected static ?string $title = 'Laporan Transaksi';
    protected static ?string $navigationGroup = 'Laporan';

    protected static string $view = 'filament.pages.laporan-transaksi';

    protected function getTableQuery(): Builder
    {
        return Transaksi::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('ID'),
            Tables\Columns\TextColumn::make('tanggal_transaksi')->label('Tanggal')->date(),
            Tables\Columns\TextColumn::make('user.name')->label('User'),
            Tables\Columns\TextColumn::make('status')->badge()->colors([
                'warning' => 'dikemas',
                'primary' => 'dikirim',
                'success' => 'selesai',
                'danger' => 'dibatalkan',
            ]),
            Tables\Columns\TextColumn::make('total_harga')
                ->label('Total')
                ->money('IDR', true),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('tanggal')
                ->form([
                    Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                    Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                ])
                ->query(
                    fn(Builder $query, array $data) =>
                    $query
                        ->when(
                            $data['from'],
                            fn($q) =>
                            $q->whereDate('tanggal_transaksi', '>=', $data['from'])
                        )
                        ->when(
                            $data['until'],
                            fn($q) =>
                            $q->whereDate('tanggal_transaksi', '<=', $data['until'])
                        )
                ),

            Tables\Filters\SelectFilter::make('status')->options([
                'dikemas' => 'Dikemas',
                'dikirim' => 'Dikirim',
                'diterima' => 'Diterima',
                'selesai' => 'Selesai',
                'dibatalkan' => 'Dibatalkan',
            ]),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('cetak')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->url(function () {
                    $filters = $this->tableFilters;

                    $from = $filters['tanggal']['from'] ?? null;

                    $bulan = $from
                        ? (int) Carbon::parse($from)->month
                        : (int) now()->month;

                    $tahun = $from
                        ? (int) Carbon::parse($from)->year
                        : (int) now()->year;


                    return route('laporan.transaksi.cetak', [
                        'bulan'  => (int) $bulan,
                        'tahun'  => (int) $tahun,
                        'status' => $filters['status'] ?? null,
                    ]);
                })
                ->openUrlInNewTab(),
        ];
    }

    protected function getTableFooter(): ?\Illuminate\Contracts\View\View
    {
        $total = $this->getTableQuery()->sum('total_harga');

        return view('filament.pages.partials.total-footer', [
            'total' => $total,
        ]);
    }
}
