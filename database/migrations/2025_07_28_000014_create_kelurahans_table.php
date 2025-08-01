<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 255);
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelurahan');
    }
};
