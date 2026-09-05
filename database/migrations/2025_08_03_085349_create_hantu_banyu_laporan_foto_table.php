<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::disableForeignKeyConstraints();

    Schema::create('hantu_banyu_laporan_foto', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('laporan_id')->index();
      $table->foreign('laporan_id')->references('id')->on('hantu_banyu_laporan');
      $table->string('foto');
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::enableForeignKeyConstraints();
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('hantu_banyu_laporan_foto');
  }
};
