<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jejak siapa saja yang sudah pernah membuka sebuah album kegiatan.
 *
 * Tabel ini bukan sumber angka yang ditampilkan - yang tampil tetap
 * album_kegiatan.views_count. Gunanya semata agar satu pengunjung hanya boleh
 * menambah hitungan sekali per album, memakai visitor_id yang sama dengan
 * statistik pengunjung. Pasangan (visitor_id, id_album_kegiatan) dibuat unik
 * supaya dua permintaan kembar yang datang bersamaan tidak bisa lolos berdua.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('album_kegiatan_views', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('visitor_id', 64);
      $table->unsignedBigInteger('id_album_kegiatan');
      $table->timestamp('viewed_at')->useCurrent();

      $table->unique(['visitor_id', 'id_album_kegiatan']);
      $table->foreign('id_album_kegiatan')->references('id')->on('album_kegiatan')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('album_kegiatan_views');
  }
};
