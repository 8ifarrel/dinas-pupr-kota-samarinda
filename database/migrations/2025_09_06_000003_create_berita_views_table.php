<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jejak siapa saja yang sudah pernah membuka sebuah berita.
 *
 * Tabel ini bukan sumber angka yang ditampilkan - yang tampil tetap
 * berita.views_count. Gunanya semata agar satu pengunjung hanya boleh
 * menambah hitungan sekali per berita, memakai visitor_id yang sama dengan
 * statistik pengunjung. Pasangan (visitor_id, uuid_berita) dibuat unik supaya
 * dua permintaan kembar yang datang bersamaan tidak bisa lolos berdua.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('berita_views', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('visitor_id', 64);
      $table->char('uuid_berita', 36);
      $table->timestamp('viewed_at')->useCurrent();

      $table->unique(['visitor_id', 'uuid_berita']);
      $table->foreign('uuid_berita')->references('uuid_berita')->on('berita')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('berita_views');
  }
};
