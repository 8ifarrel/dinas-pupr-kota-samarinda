<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('berita_kategori', function (Blueprint $table) {
            $table->bigIncrements('id_berita_kategori');
            $table->unsignedBigInteger('id_susunan_organisasi');
            $table->string('ikon_berita_kategori', 255)->nullable();
            $table->timestamps();
            $table->foreign('id_susunan_organisasi')->references('id_susunan_organisasi')->on('susunan_organisasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita_kategori');
    }
};
