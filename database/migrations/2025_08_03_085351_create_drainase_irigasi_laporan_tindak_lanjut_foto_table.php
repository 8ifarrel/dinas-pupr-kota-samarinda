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
        Schema::disableForeignKeyConstraints();

        Schema::create('drainase_irigasi_laporan_tindak_lanjut_foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tindak_lanjut_id')->index('idx_tindak_lanjut');
            $table->foreign('tindak_lanjut_id', 'fk_tindak_lanjut_foto')->references('id')->on('drainase_irigasi_laporan_tindak_lanjut');
            $table->string('foto');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drainase_irigasi_laporan_tindak_lanjut_foto');
    }
};
