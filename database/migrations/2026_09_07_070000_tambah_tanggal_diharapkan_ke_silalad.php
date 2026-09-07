<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tanggal yang diharapkan pelanggan untuk penyedotan.
 *
 * Sebelumnya pelanggan tidak punya cara menyebutkan kapan ia ingin dilayani,
 * padahal FAQ di halaman depan menjanjikan "pilih lokasi & jadwal". Akibatnya
 * tiap pesanan wajib ditindaklanjuti telepon hanya untuk menanyakan hal itu.
 *
 * Sifatnya PREFERENSI, bukan pemesanan slot: aplikasi ini tidak menyimpan
 * kuota harian maupun ketersediaan armada, jadi tidak ada yang bisa dipakai
 * untuk menjanjikan tanggal. Keputusan tetap di admin lewat
 * `tanggal_perintah`. Nullable, supaya pesanan lama tetap sah dan pelanggan
 * yang tidak punya preferensi tetap bisa mendaftar.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::table('silalad', function (Blueprint $table) {
      $table->date('tanggal_diharapkan')->nullable()->after('detail_laporan');
    });
  }

  public function down(): void
  {
    Schema::table('silalad', function (Blueprint $table) {
      $table->dropColumn('tanggal_diharapkan');
    });
  }
};
