<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->string('id_buku_tamu', 255)->primary();
            $table->string('nama_pengunjung', 255);
            $table->string('nomor_telepon', 255);
            $table->string('email', 255);
            $table->text('alamat');
            $table->unsignedBigInteger('jabatan_yang_dikunjungi');
            $table->text('maksud_dan_tujuan');
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            $table->text('deskripsi_status')->nullable();
            $table->timestamps();
            $table->foreign('jabatan_yang_dikunjungi')->references('id_susunan_organisasi')->on('susunan_organisasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku_tamu');
    }
};
