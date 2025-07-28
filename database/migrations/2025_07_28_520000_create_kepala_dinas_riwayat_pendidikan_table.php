<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kepala_dinas_riwayat_pendidikan', function (Blueprint $table) {
            $table->bigIncrements('id_pendidikan');
            $table->unsignedBigInteger('id_kepala_dinas')->nullable();
            $table->string('nama_pendidikan', 255);
            $table->date('tanggal_masuk')->nullable();
            $table->unsignedBigInteger('id_susunan_organisasi');
            $table->timestamps();
            $table->foreign('id_kepala_dinas')->references('id')->on('kepala_dinas')->onDelete('set null');
            $table->foreign('id_susunan_organisasi')->references('id_susunan_organisasi')->on('susunan_organisasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kepala_dinas_riwayat_pendidikan');
    }
};
