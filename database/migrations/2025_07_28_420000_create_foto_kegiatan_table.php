<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('foto_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('foto', 255);
            $table->string('caption', 255)->nullable();
            $table->unsignedBigInteger('id_album_kegiatan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_kegiatan');
    }
};
