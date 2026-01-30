<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->dropColumn('metode_pembayaran');

        $table->string('ekspedisi')->nullable();
        $table->date('tanggal_selesai')->nullable();
        $table->string('order_id')->nullable()->unique();
        $table->string('snap_token')->nullable();
    });
}

public function down()
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->string('metode_pembayaran')->nullable();

        $table->dropColumn(['ekspedisi', 'tanggal_selesai', 'order_id', 'snap_token']);
    });
}

};
