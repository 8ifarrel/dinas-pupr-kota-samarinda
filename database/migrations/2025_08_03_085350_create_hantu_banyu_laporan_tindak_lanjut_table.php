<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::disableForeignKeyConstraints();

    Schema::create('hantu_banyu_laporan_tindak_lanjut', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('laporan_id')->index();
      $table->foreign('laporan_id')->references('id')->on('hantu_banyu_laporan');
      $table->enum('status', ["pending","diterima","menunggu_survei","sudah_disurvei","menunggu_jadwal_pengerjaan","sedang_dikerjakan","selesai"]);
      $table->text('deskripsi')->default('Laporan telah masuk. Mohon menunggu proses lebih lanjut');
      $table->enum('jenis', ["belum_diklasifikasikan","darurat","biasa","rutin"])->default('belum_diklasifikasikan');
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
    Schema::dropIfExists('hantu_banyu_laporan_tindak_lanjut');
  }
};
