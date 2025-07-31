<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('susunan_organisasi', function (Blueprint $table) {
            $table->bigIncrements('id_susunan_organisasi');
            $table->string('nama_susunan_organisasi', 255)->unique();
            $table->unsignedBigInteger('id_susunan_organisasi_parent')->nullable();
            $table->string('slug_susunan_organisasi', 255)->unique();
            $table->text('tupoksi_susunan_organisasi')->nullable();
            $table->text('deskripsi_susunan_organisasi')->nullable();
            $table->enum('kelompok_susunan_organisasi', ['UPTD','Bidang','Kepala Dinas','Sekretariat']);
            $table->boolean('is_subbagian')->default(0);
            $table->boolean('is_susunan_organisasi_fungsional')->default(0);
            $table->timestamps();
            $table->foreign('id_susunan_organisasi_parent')->references('id_susunan_organisasi')->on('susunan_organisasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('susunan_organisasi');
    }
};
