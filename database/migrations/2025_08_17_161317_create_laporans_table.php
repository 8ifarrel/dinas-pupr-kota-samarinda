<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->string('id_laporan')->primary();
            
            // $table->foreignId('pelapor_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_ponsel');
            $table->foreign('nomor_ponsel')
                ->references('nomor_ponsel')
                ->on('pelapors')
                ->cascadeOnDelete();
            $table->text('alamat_lengkap_kerusakan');
            $table->string('deskripsi_laporan');
            $table->string('link_koordinat');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('foto_kerusakan');
            $table->foreignId('kecamatan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelurahan_id')->constrained()->cascadeOnDelete();
            $table->string('kota')->default('Kota Samarinda');
            $table->text('feedback')->nullable();
            $table->unsignedTinyInteger('rating_kepuasan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto_lanjutan')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')
                ->references('status_id')
                ->on('status')
                ->cascadeOnDelete();
            $table->string('jenis_kerusakan')->nullable();
            //real kolom
            $table->string('tingkat_kerusakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};