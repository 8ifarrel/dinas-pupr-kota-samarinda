<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom penugasan & pelaksanaan pesanan SILALAD.
 *
 * Ketiga surat bawaan branch sumber (Surat Pesanan, Surat Perintah Kerja,
 * Surat Jalan) mengambil data yang tidak punya kolom sama sekali di tabel,
 * sehingga cetakannya selalu kosong. Kolom-kolom di sini yang melengkapinya.
 *
 * Semuanya nullable: pesanan baru masuk memang belum disurvei, belum
 * ditugaskan, dan belum dikerjakan.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::table('silalad', function (Blueprint $table) {
      // Survei kelayakan (Surat Pesanan)
      $table->string('nomor_spk', 100)->nullable()->after('status_pengerjaan');
      $table->unsignedSmallInteger('jarak_tangki')->nullable()->after('nomor_spk');
      $table->boolean('bisa_disedot')->nullable()->after('jarak_tangki');
      $table->date('tanggal_pesanan')->nullable()->after('bisa_disedot');

      // Penugasan (Surat Perintah Kerja)
      $table->string('nama_operator', 150)->nullable()->after('tanggal_pesanan');
      $table->string('nomor_kendaraan', 30)->nullable()->after('nama_operator');
      $table->string('kapasitas_kendaraan', 30)->nullable()->after('nomor_kendaraan');
      $table->date('tanggal_perintah')->nullable()->after('kapasitas_kendaraan');

      // Pelaksanaan (Surat Jalan)
      $table->unsignedSmallInteger('jumlah_rit')->nullable()->after('tanggal_perintah');
      $table->date('tanggal_jalan')->nullable()->after('jumlah_rit');

      // Pembatalan
      $table->text('alasan_batal')->nullable()->after('tanggal_jalan');
    });
  }

  public function down(): void
  {
    Schema::table('silalad', function (Blueprint $table) {
      $table->dropColumn([
        'nomor_spk',
        'jarak_tangki',
        'bisa_disedot',
        'tanggal_pesanan',
        'nama_operator',
        'nomor_kendaraan',
        'kapasitas_kendaraan',
        'tanggal_perintah',
        'jumlah_rit',
        'tanggal_jalan',
        'alasan_batal',
      ]);
    });
  }
};
