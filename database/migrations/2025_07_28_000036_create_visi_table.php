<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('visi', function (Blueprint $table) {
            $table->bigIncrements('id_visi');
            $table->text('deskripsi_visi');
            $table->year('periode_mulai');
            $table->year('periode_selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visi');
    }
};
