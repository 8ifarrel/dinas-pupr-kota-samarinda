<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jalan_peduli_pelapor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nomor_ponsel')->unique();
            $table->string('email')->nullable();

            $table->unsignedSmallInteger('kecamatan_id');
            $table->foreign('kecamatan_id')
                ->references('id')
                ->on('kecamatan')
                ->onDelete('cascade');

            $table->unsignedSmallInteger('kelurahan_id');
            $table->foreign('kelurahan_id')
                ->references('id')
                ->on('kelurahan')
                ->onDelete('cascade');

            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('alamat_pelapor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalan_peduli_pelapor');
    }
};
