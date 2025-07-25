<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lpse', function (Blueprint $table) {
            $table->id();
            $table->string('kode_paket');
            $table->string('nama_paket');
            $table->string('jenis_paket'); // enum bisa diproses di model
            $table->string('url_informasi_paket');
            $table->bigInteger('nilai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lpse');
    }
};