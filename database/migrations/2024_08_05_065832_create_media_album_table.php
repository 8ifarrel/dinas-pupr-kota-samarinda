<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('media_album', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('media_album');
    }
};