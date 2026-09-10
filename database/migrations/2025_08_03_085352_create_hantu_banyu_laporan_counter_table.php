<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Penghitung nomor laporan Hantu Banyu per tahun.
 *
 * Satu baris per tahun; `terakhir` menyimpan nomor urut terakhir yang sudah
 * dipakai pada tahun itu. Nomor berikutnya diambil dengan mengunci baris ini
 * (SELECT ... FOR UPDATE) lalu menaikkannya, sehingga tetap benar walau ada
 * laporan yang di-soft-delete (nomornya tidak pernah dipakai ulang) maupun
 * saat dua permintaan datang nyaris bersamaan.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('hantu_banyu_laporan_counter', function (Blueprint $table) {
      $table->unsignedSmallInteger('tahun')->primary();
      $table->unsignedInteger('terakhir')->default(0);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('hantu_banyu_laporan_counter');
  }
};
