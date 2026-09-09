<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Singkatan tiap unit organisasi, dipakai di tempat yang butuh label ringkas
 * (mis. dropdown "Akun Saya" di sisi guest) - nama lengkap seperti "UPTD
 * Pemeliharaan Saluran Drainase dan Irigasi" terlalu panjang untuk itu.
 */
return new class extends Migration {
  public function up(): void
  {
    Schema::table('susunan_organisasi', function (Blueprint $table) {
      $table->string('singkatan_susunan_organisasi', 50)->nullable()->after('nama_susunan_organisasi');
    });
  }

  public function down(): void
  {
    Schema::table('susunan_organisasi', function (Blueprint $table) {
      $table->dropColumn('singkatan_susunan_organisasi');
    });
  }
};
