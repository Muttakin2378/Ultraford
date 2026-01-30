<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBarangMasuk extends CreateRecord
{
    protected static string $resource = BarangMasukResource::class;

    protected function afterCreate(): void
    {
        admin_log(
            'Tambah Barang Masuk',
            'Menambahkan barang masuk #' . $this->record->id,
            $this->record
        );
    }
}
