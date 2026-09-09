<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Catat asal pembuat laporan Hantu Banyu.
 *
 * Sebelumnya seluruh laporan pasti dibuat operator kelurahan, jadi asalnya
 * tidak perlu dicatat. Sejak admin UPTD boleh membuat laporan atas nama
 * kelurahan mana pun, kolom ini yang membedakan keduanya di kolom "Pelapor"
 * dan filternya.
 */
return new class extends Migration {
  public function up(): void
  {
    Schema::table('hantu_banyu_laporan', function (Blueprint $table) {
      $table->enum('dibuat_oleh_tipe', ['kelurahan', 'admin'])
        ->default('kelurahan')
        ->after('pelapor_id');

      // Admin mana yang membuat - untuk keperluan telusur. Dibiarkan kosong
      // untuk laporan operator kelurahan, dan tidak ikut terhapus kalau akun
      // adminnya dihapus (laporannya tetap sah).
      $table->unsignedBigInteger('dibuat_oleh_user_id')
        ->nullable()
        ->after('dibuat_oleh_tipe');
      $table->foreign('dibuat_oleh_user_id')->references('id')->on('users')->nullOnDelete();

      $table->index('dibuat_oleh_tipe');
    });
  }

  public function down(): void
  {
    Schema::table('hantu_banyu_laporan', function (Blueprint $table) {
      $table->dropForeign(['dibuat_oleh_user_id']);
      $table->dropIndex(['dibuat_oleh_tipe']);
      $table->dropColumn(['dibuat_oleh_tipe', 'dibuat_oleh_user_id']);
    });
  }
};
