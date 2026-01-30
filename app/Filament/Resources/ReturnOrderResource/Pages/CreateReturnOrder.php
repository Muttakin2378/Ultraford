<?php

namespace App\Filament\Resources\ReturnOrderResource\Pages;

use App\Filament\Resources\ReturnOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReturnOrder extends CreateRecord
{
    protected static string $resource = ReturnOrderResource::class;

    protected function afterCreate(): void
    {
        admin_log(
            'Tambah Barang Masuk',
            'Menambahkan barang masuk #' . $this->record->id,
            $this->record
        );
    }
}
