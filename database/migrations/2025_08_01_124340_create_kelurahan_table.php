<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('kelurahan', function (Blueprint $table) {
      $table->unsignedSmallInteger('id')->primary();
      $table->string('nama')->unique();
      $table->unsignedSmallInteger('kecamatan_id');

      $table->foreign('kecamatan_id')
        ->references('id')
        ->on('kecamatan')
        ->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('kelurahan');
  }
};