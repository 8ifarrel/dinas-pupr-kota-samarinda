<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Fitur Buku Tamu dipindahkan seutuhnya ke branch buku-tamu dan dihapus dari
 * main (lihat komit "Hapus fitur Buku Tamu dari main"). Migrasi ini
 * membereskan sisa jejaknya di basis data yang sudah berjalan, yang tidak
 * ikut berubah hanya karena berkas kodenya dihapus:
 *
 *  - tabel buku_tamu beserta isinya,
 *  - baris layanan bernama "buku_tamu" (id 4),
 *  - catatan migrations untuk berkas migrasi yang sudah tidak ada, supaya
 *    "php artisan migrate:rollback" di masa depan tidak mencari kelas yang
 *    tidak lagi ada.
 *
 * Baris SKM yang menunjuk ke layanan ini tidak dihapus. Foreign key-nya
 * "on delete set null" (lihat 2025_07_28_160000_create_skm_table), sehingga
 * masukan SKM tetap tersimpan, hanya kehilangan tautan ke layanan yang sudah
 * tiada. Riwayat kritik/saran warga tidak seharusnya ikut hilang gara-gara
 * layanannya dibubarkan.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::dropIfExists('buku_tamu');

    DB::table('layanan')->where('nama', 'buku_tamu')->delete();

    DB::table('migrations')
      ->where('migration', '2025_07_28_300000_create_buku_tamu_table')
      ->delete();
  }

  /**
   * Rollback tidak mengembalikan data lama (sudah tiada di berkas migrasi
   * manapun pada main), hanya mengembalikan skema kosong dan baris layanan-nya
   * agar migrate:rollback tidak meninggalkan basis data dalam keadaan aneh.
   * Data asli tersimpan di branch buku-tamu bila suatu saat dibutuhkan.
   */
  public function down(): void
  {
    Schema::create('buku_tamu', function ($table) {
      $table->string('id_buku_tamu', 255)->primary();
      $table->string('nama_pengunjung', 255);
      $table->string('nomor_telepon', 255);
      $table->string('email', 255);
      $table->text('alamat');
      $table->unsignedBigInteger('jabatan_yang_dikunjungi');
      $table->text('maksud_dan_tujuan');
      $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
      $table->text('deskripsi_status')->nullable();
      $table->timestamps();
      $table->foreign('jabatan_yang_dikunjungi')->references('id_susunan_organisasi')->on('susunan_organisasi')->onDelete('cascade');
    });

    DB::table('layanan')->updateOrInsert(
      ['id' => 4],
      ['nama' => 'buku_tamu', 'struktur_organisasi_id' => null]
    );
  }
};
