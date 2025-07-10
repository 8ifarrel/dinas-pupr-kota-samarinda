<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrukturOrganisasiSliderTable extends Migration
{
    public function up()
    {
        Schema::create('struktur_organisasi_slider', function (Blueprint $table) {
            $table->id('id_slider');
            $table->unsignedInteger('id_struktur_organisasi');
            $table->string('foto');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('id_struktur_organisasi')
                  ->references('id_struktur_organisasi')
                  ->on('struktur_organisasi')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('struktur_organisasi_slider');
    }
}


