<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('agenda_kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nama')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->string('tempat', 191)->nullable();
            $table->string('pelaksana', 255);
            $table->string('dihadiri_oleh', 191)->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
            $table->index('tanggal', 'idx_tanggal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda_kegiatan');
    }
};
