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
        Schema::create('pelapors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nomor_ponsel')->unique();
            $table->string('email')->nullable();
            $table->foreignId('kecamatan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelurahan_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('pelapors');
    }
};
