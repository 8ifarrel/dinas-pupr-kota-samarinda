<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ppid_pelaksana', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->string('file', 255);
            $table->unsignedBigInteger('id_kategori');
            $table->integer('download_count')->default(0);
            $table->timestamps();
            $table->foreign('id_kategori')->references('id')->on('ppid_pelaksana_kategori')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppid_pelaksana');
    }
};
