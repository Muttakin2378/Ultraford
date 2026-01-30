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
        Schema::create('admin_activity_logs', function (Blueprint $table) {
    $table->id();

    $table->foreignId('admin_id')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->string('aksi');
    $table->string('model')->nullable();
    $table->unsignedBigInteger('model_id')->nullable();

    $table->text('keterangan')->nullable();
    $table->string('ip')->nullable();
    $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activity_logs');
    }
};
