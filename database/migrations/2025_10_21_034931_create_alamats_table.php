<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // 🔁 GANTI dari pelanggan_id → user_id
            $table->string('label', 50)->nullable(); // Rumah, Kantor, dll
            $table->string('nama_penerima', 100);
            $table->string('telepon_penerima', 20);
            $table->text('alamat_lengkap');
            $table->string('kota', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamats');
    }
};
