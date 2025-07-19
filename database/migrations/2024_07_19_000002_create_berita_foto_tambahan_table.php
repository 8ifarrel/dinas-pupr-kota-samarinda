<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaFotoTambahanTable extends Migration
{
    public function up()
    {
        Schema::create('berita_foto_tambahan', function (Blueprint $table) {
            $table->id('id_berita_foto_tambahan');
            $table->string('uuid_berita', 36);
            $table->string('foto_path');
            $table->string('caption')->nullable();
            $table->timestamps();

            $table->foreign('uuid_berita')->references('uuid_berita')->on('berita')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita_foto_tambahan');
    }
}
