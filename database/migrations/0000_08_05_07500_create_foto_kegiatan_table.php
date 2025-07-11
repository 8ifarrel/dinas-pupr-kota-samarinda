<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foto_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('caption')->nullable();
            $table->foreignId('id_album_kegiatan')->constrained('album_kegiatan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_kegiatan');
    }
};

