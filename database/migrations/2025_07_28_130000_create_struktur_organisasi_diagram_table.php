<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('struktur_organisasi_diagram', function (Blueprint $table) {
            $table->bigIncrements('id_struktur_organisasi_diagram');
            $table->unsignedInteger('id_struktur_organisasi')->nullable();
            $table->string('diagram_struktur_organisasi', 255);
            $table->timestamps();
            $table->foreign('id_struktur_organisasi')->references('id_struktur_organisasi')->on('struktur_organisasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('struktur_organisasi_diagram');
    }
};
