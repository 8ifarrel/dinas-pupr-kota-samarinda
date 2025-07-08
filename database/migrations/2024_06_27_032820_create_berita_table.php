<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->uuid('uuid_berita');
            $table->string('judul_berita')->unique();
            $table->string('slug_berita')->unique();
            $table->unsignedBigInteger('id_berita_kategori');
            $table->string('foto_berita');
            $table->string('sumber_foto_berita');
            $table->text('isi_berita');
            $table->integer('views_count')->default(0);
            $table->timestamps();

            $table->foreign('id_berita_kategori')
                  ->references('id_berita_kategori')
                  ->on('berita_kategori')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
}
