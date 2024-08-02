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
            $table->unsignedBigInteger('id_jabatan');
            $table->string('ikon_jabatan')->nullable();
            $table->integer('nomor_urut_jabatan')->unique();
            $table->timestamps();

            $table->foreign('id_jabatan')
                  ->references('id_jabatan')
                  ->on('jabatan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('struktur_organisasi');
    }
}
