<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kunci unik (silalad_id, status) di `silalad_tindak_lanjut`.
 *
 * Sejak riwayat tindak lanjut diubah jadi berbasis "slot" (satu baris per
 * status, diedit di tempat lewat `updateOrCreate` - meniru pola Hantu Banyu,
 * lihat SilaladAdminController::simpanSlot()), aplikasi sudah mengasumsikan
 * tidak pernah ada dua baris berstatus sama untuk pesanan yang sama.
 * Constraint ini membuat basis data ikut menjaga asumsi itu, bukan cuma
 * dipercaya dari sisi kode - melindungi dari duplikasi kalau suatu saat ada
 * jalur lain yang menulis ke tabel ini tanpa lewat `updateOrCreate`, atau
 * dua request bersamaan mencoba mengisi slot yang sama.
 *
 * Aman dijalankan di data yang sudah ada: sudah diperiksa manual sebelum
 * migrasi ini ditulis, tidak ada pasangan (silalad_id, status) yang
 * terduplikasi.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::table('silalad_tindak_lanjut', function (Blueprint $table) {
      $table->unique(['silalad_id', 'status'], 'silalad_tindak_lanjut_silalad_id_status_unique');
    });
  }

  public function down(): void
  {
    Schema::table('silalad_tindak_lanjut', function (Blueprint $table) {
      $table->dropUnique('silalad_tindak_lanjut_silalad_id_status_unique');
    });
  }
};
