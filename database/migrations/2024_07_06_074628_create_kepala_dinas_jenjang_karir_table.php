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
        Schema::create('kepala_dinas_jenjang_karir', function (Blueprint $table) {
			$table->id('id_karir');
			$table->string('nama_karir');
			$table->date('tanggal_masuk');
			$table->unsignedBigInteger('id_susunan_organisasi');
			$table->timestamps();

			$table->foreign('id_susunan_organisasi')
				->references('id_susunan_organisasi')
				->on('susunan_organisasi')
				->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepala_dinas_jenjang_karir');
    }
};

