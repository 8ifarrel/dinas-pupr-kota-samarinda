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
        Schema::create('sejarah_dinas_pupr_kota_samarinda', function (Blueprint $table) {
			$table->id('id_sejarah_dinas_pupr_kota_samarinda');
			$table->text('deskripsi_sejarah_dinas_pupr_kota_samarinda');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sejarah_dinas_pupr_kota_samarinda');
    }
};
