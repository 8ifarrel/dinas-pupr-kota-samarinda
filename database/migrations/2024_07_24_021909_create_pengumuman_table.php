<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
  public function up()
  {
    Schema::create('pengumuman', function (Blueprint $table) {
      $table->id();
      $table->string('judul_pengumuman');
      $table->string('slug_pengumuman');
      $table->text('perihal');
      $table->string('file_lampiran');
      $table->bigInteger('views_count');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('pengumuman');
  }
}

