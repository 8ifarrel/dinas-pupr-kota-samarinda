<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('album_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('album_kegiatan');
    }
};
