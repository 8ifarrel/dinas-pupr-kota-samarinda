<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kepala_dinas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 255);
            $table->string('foto', 255)->nullable();
            $table->string('nip', 18);
            $table->string('nomor_telepon', 15);
            $table->enum('golongan', ['I/a','I/b','I/c','I/d','II/a','II/b','II/c','II/d','III/a','III/b','III/c','III/d','IV/a','IV/b','IV/c','IV/d','IV/e']);
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');
            $table->unsignedBigInteger('id_susunan_organisasi')->nullable();
            $table->timestamps();
            $table->foreign('id_susunan_organisasi')->references('id_susunan_organisasi')->on('susunan_organisasi')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kepala_dinas');
    }
};
