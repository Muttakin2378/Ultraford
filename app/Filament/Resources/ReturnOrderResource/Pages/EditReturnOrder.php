<?php

namespace App\Filament\Resources\ReturnOrderResource\Pages;

use App\Filament\Resources\ReturnOrderResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\Notif;
use Filament\Notifications\Notification;

class EditReturnOrder extends EditRecord
{
    protected static string $resource = ReturnOrderResource::class;

    protected function afterSave(): void
    {
        $return = $this->record;

        // 🔔 NOTIFIKASI KE USER
        if ($return->status === 'disetujui') {

            Notif::create([
                'user_id' => $return->user_id,
                'tanggal' => now(),
                'notifikasi' =>
                'Permohonan return untuk transaksi #' .
                    $return->transaksi_id .
                    ' telah DISETUJUI. Mohon segera mengirimkan paket melalui ekspedisi terdekat sebelum tanggal ' . now()->addDays(7),
                'status' => 'belum_dibaca',
            ]);
            admin_log(
                'Return',
                'Menyetujui return #' . $this->record->id,
                $this->record
            );
        }

        if ($return->status === 'diterima') {

            Notif::create([
                'user_id' => $return->user_id,
                'tanggal' => now(),
                'notifikasi' =>
                'Permohonan return untuk transaksi #' .
                    $return->transaksi_id .
                    ' Return telah sukses, Uang pembayaran telah di tambahkan ke saldo ',
                'status' => 'belum_dibaca',
            ]);

            $user = $return->user;
            $total = $return->transaksi?->total_harga ?? 0;
            $user->increment('saldo', $total);

            admin_log(
                'Return',
                'Menerima return #' . $this->record->id,
                $this->record
            );
        }

        if ($return->status === 'ditolak') {

            Notif::create([
                'user_id' => $return->user_id,
                'tanggal' => now(),
                'notifikasi' =>
                'Permohonan return untuk transaksi #' .
                    $return->transaksi_id .
                    ' DITOLAK. Catatan: ' .
                    ($return->catatan_admin ?? '-'),
                'status' => 'belum_dibaca',
            ]);

            admin_log(
                'Return',
                'Menolak return #' . $this->record->id,
                $this->record
            );
        }

        // 🔔 NOTIFIKASI KE ADMIN (UI FILAMENT)
        Notification::make()
            ->title('Return berhasil diproses')
            ->success()
            ->send();
    }
}
