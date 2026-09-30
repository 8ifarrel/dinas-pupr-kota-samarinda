<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Log pemeriksaan berkala ruas saluran drainase/irigasi - kegiatan patroli
 * rutin UPTD PSDI, berdiri sendiri dari pengaduan warga (hantu_banyu_laporan):
 * mencakup ruas mana pun, termasuk yang belum pernah dikeluhkan, dan sengaja
 * tidak punya keterkaitan apa pun ke tabel laporan pengaduan.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('hantu_banyu_pemeriksaan_berkala', function (Blueprint $table) {
      $table->id();
      $table->date('tanggal_pemeriksaan')->index();

      // Lokasi terstruktur: kecamatan -> kelurahan -> nama jalan (dipilih lewat
      // pencarian jalan OSM yang dibatasi pada kelurahan terpilih, sama seperti
      // form pengaduan).
      $table->unsignedSmallInteger('kecamatan_id')->index();
      $table->foreign('kecamatan_id')->references('id')->on('kecamatan');
      $table->unsignedSmallInteger('kelurahan_id')->index();
      $table->foreign('kelurahan_id')->references('id')->on('kelurahan');
      $table->string('nama_jalan', 150);
      // Jenis ruas saluran: hanya tiga tingkatan baku (primer/sekunder/tersier).
      $table->enum('nama_ruas_saluran', ['primer', 'sekunder', 'tersier']);

      $table->decimal('dimensi_lebar_m', 5, 2);
      $table->decimal('dimensi_tinggi_m', 5, 2);
      $table->text('kondisi_fisik_struktur');
      // Diinput sebagai kedalaman sedimentasi/sampah dalam cm; persentase &
      // kategorinya (Normal/Sedang/Tinggi) dihitung otomatis dari kolom ini
      // dibagi dimensi_tinggi_m (lihat accessor pada model), tidak disimpan
      // terpisah supaya tidak bisa basi bila dimensi_tinggi_m diubah belakangan.
      $table->decimal('tingkat_sedimentasi_sampah_cm', 5, 1);
      $table->enum('status_aliran_air', ['lancar', 'kurang_lancar', 'tersumbat_sebagian', 'macet_total']);
      $table->text('tindakan_pemeliharaan');
      $table->text('hambatan_kendala');
      $table->text('rekomendasi_tindak_lanjut');

      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('hantu_banyu_pemeriksaan_berkala');
  }
};
