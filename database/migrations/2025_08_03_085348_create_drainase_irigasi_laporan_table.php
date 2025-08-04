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

        Schema::create('drainase_irigasi_laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelapor_id')->unique()->index();
            $table->foreign('pelapor_id')->references('id')->on('drainase_irigasi_pelapor');
            $table->string('nama_jalan', 150);
            $table->unsignedSmallInteger('kecamatan_id')->index();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan');
            $table->unsignedSmallInteger('kelurahan_id')->index();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahan');
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 9, 2);
            $table->text('detail_lokasi');
            $table->text('deskripsi_kerusakan');
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
        Schema::dropIfExists('drainase_irigasi_laporan');
    }
};
