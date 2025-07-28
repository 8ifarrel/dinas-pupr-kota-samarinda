<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->char('uuid_berita', 36)->primary();
            $table->string('judul_berita', 255)->unique();
            $table->string('slug_berita', 255)->unique();
            $table->unsignedBigInteger('id_berita_kategori');
            $table->string('foto_berita', 255);
            $table->string('sumber_foto_berita', 255)->nullable();
            $table->text('isi_berita');
            $table->string('preview_berita', 255);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            $table->foreign('id_berita_kategori')->references('id_berita_kategori')->on('berita_kategori')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};
