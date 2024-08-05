<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media_galeri', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('foto');
            $table->string('caption')->nullable();
            $table->foreignId('id_media_album')->constrained('media_album')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_galeri');
    }
};
