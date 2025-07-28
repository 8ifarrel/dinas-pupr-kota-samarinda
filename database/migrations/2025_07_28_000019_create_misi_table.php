<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('misi', function (Blueprint $table) {
            $table->bigIncrements('id_misi');
            $table->integer('nomor_urut');
            $table->text('deskripsi_misi');
            $table->year('periode_mulai');
            $table->year('periode_selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('misi');
    }
};
