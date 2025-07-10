<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrukturOrganisasiTable extends Migration
{
    public function up()
    {
        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->increments('id_struktur_organisasi');
            $table->unsignedBigInteger('id_susunan_organisasi');
            $table->string('ikon_jabatan')->nullable();
            $table->integer('nomor_urut_jabatan')->unique();
            $table->timestamps();

            $table->foreign('id_susunan_organisasi')
                  ->references('id_susunan_organisasi')
                  ->on('susunan_organisasi')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('struktur_organisasi');
    }
}

