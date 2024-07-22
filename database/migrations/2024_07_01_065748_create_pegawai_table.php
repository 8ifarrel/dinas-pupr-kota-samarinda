<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('nama_pegawai');
            $table->string('foto_pegawai')->nullable();
            $table->string('nomor_induk_pegawai')->unique();
            $table->string('nomor_telepon_pegawai')->unique();
            $table->string('golongan_pegawai');
            $table->timestamps();

            $table->foreign('id_jabatan')
                  ->references('id_jabatan')
                  ->on('jabatan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
