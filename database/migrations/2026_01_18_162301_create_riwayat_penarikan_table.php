<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_penarikan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('kode_penarikan');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tujuan');
            $table->string('rekening');
            $table->decimal('nominal', 10, 2);
            $table->date('tanggal_penarikan');
            $table->date('tanggal_final')->nullable();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penarikan');
    }
};
