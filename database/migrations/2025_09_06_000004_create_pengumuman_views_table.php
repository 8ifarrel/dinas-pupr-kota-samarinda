<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jejak siapa saja yang sudah pernah membuka sebuah pengumuman.
 *
 * Tabel ini bukan sumber angka yang ditampilkan - yang tampil tetap
 * pengumuman.views_count. Gunanya semata agar satu pengunjung hanya boleh
 * menambah hitungan sekali per pengumuman, memakai visitor_id yang sama dengan
 * statistik pengunjung. Pasangan (visitor_id, id_pengumuman) dibuat unik supaya
 * dua permintaan kembar yang datang bersamaan tidak bisa lolos berdua.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('pengumuman_views', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('visitor_id', 64);
      $table->unsignedBigInteger('id_pengumuman');
      $table->timestamp('viewed_at')->useCurrent();

      $table->unique(['visitor_id', 'id_pengumuman']);
      $table->foreign('id_pengumuman')->references('id')->on('pengumuman')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('pengumuman_views');
  }
};
