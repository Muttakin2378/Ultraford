<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE transaksis
            SET nama_penerima = (
                SELECT a.nama_penerima
                FROM alamats a
                WHERE a.id = transaksis.alamat_id
            ),
            no_telp_penerima = (
                SELECT a.telepon_penerima
                FROM alamats a
                WHERE a.id = transaksis.alamat_id
            )
        ");
    }

    public function down(): void
    {
        // Kosongkan kembali jika rollback
        DB::statement("
            UPDATE transaksis
            SET nama_penerima = NULL, no_telp_penerima = NULL
        ");
    }
};
