<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->bigIncrements('id_slider');
            $table->string('judul_slider', 255);
            $table->string('foto_slider', 255);
            $table->integer('nomor_urut_slider')->unique();
            $table->boolean('is_visible')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slider');
    }
};
