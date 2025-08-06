<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama');
            
            $table->unsignedInteger('struktur_organisasi_id')->nullable();
            $table->foreign('struktur_organisasi_id')->references('id_struktur_organisasi')->on('struktur_organisasi')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
