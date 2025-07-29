<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul_pengumuman', 255);
            $table->string('slug_pengumuman', 255);
            $table->text('perihal');
            $table->string('file_lampiran', 255)->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengumuman');
    }
};
