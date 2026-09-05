<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('users_kelurahan', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedSmallInteger('kelurahan_id')->unique();
      $table->string('fullname', 255);
      $table->string('name', 255)->unique();
      $table->string('password', 255);
      $table->string('remember_token', 100)->nullable();
      $table->timestamps();

      $table->foreign('kelurahan_id')
        ->references('id')
        ->on('kelurahan')
        ->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('users_kelurahan');
  }
};
