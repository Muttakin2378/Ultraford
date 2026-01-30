<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // 🔁 GANTI dari pelanggan_id → user_id
            $table->foreignId('alamat_id')->constrained('alamats')->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'qris']);
            $table->enum('status', ['dikemas', 'dikirim', 'diterima', 'selesai', 'dibatalkan'])->default('dikemas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
