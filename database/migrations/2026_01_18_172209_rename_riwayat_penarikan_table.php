<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('riwayat_penarikan', 'riwayat_penarikans');
    }

    public function down()
    {
        Schema::rename('riwayat_penarikans', 'riwayat_penarikan');
    }
};
