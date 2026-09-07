<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Tanggal kapan penyedotan benar-benar dieksekusi.
 *
 * Sebelumnya tidak ada kolom untuk ini. Status "Dijadwalkan" berarti tanggal
 * sudah ditetapkan, tapi satu-satunya tanggal yang tersimpan saat itu adalah
 * `tanggal_perintah` - dan itu tanggal terbitnya Surat Perintah Kerja, bukan
 * tanggal kerja. Akibatnya riwayat pesanan dan balasan API sempat menyebut
 * tanggal surat seolah-olah jadwal pengerjaan.
 *
 * Pembagian tanggal setelah migrasi ini:
 *   tanggal_diharapkan  - diminta pelanggan saat mendaftar
 *   tanggal_pelaksanaan - kapan penyedotan dieksekusi (ditetapkan admin)
 *   tanggal_pesanan     - tanggal terbit Surat Pesanan       (otomatis)
 *   tanggal_perintah    - tanggal terbit Surat Perintah Kerja (otomatis)
 *   tanggal_jalan       - tanggal terbit Surat Jalan          (otomatis)
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::table('silalad', function (Blueprint $table) {
      $table->date('tanggal_pelaksanaan')->nullable()->after('tanggal_diharapkan');
    });

    // Pesanan yang sudah selesai: tanggal Surat Jalan dulu dipakai admin
    // sebagai tanggal pengerjaan, jadi itu tebakan terbaik yang tersedia.
    DB::table('silalad')
      ->whereNull('tanggal_pelaksanaan')
      ->whereNotNull('tanggal_jalan')
      ->update(['tanggal_pelaksanaan' => DB::raw('tanggal_jalan')]);
  }

  public function down(): void
  {
    Schema::table('silalad', function (Blueprint $table) {
      $table->dropColumn('tanggal_pelaksanaan');
    });
  }
};
