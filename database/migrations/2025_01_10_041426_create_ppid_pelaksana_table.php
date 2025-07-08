<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_pelaksana', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('file');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('download_count')->default(0);
            $table->timestamps();

            $table->foreign('id_kategori')->references('id')->on('ppid_pelaksana_kategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_pelaksana');
    }
};

