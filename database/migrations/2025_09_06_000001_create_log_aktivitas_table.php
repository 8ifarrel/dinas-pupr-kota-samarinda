<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jejak audit perubahan data (tambah, ubah, hapus, pulihkan).
 *
 * Identitas pelaku sengaja disimpan sebagai salinan teks (pelaku_nama,
 * pelaku_username), bukan hanya id yang menunjuk ke tabel users. Sebab akun
 * admin bisa dihapus, sementara jejak auditnya justru harus tetap terbaca
 * setelah akun itu tidak ada lagi.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('log_aktivitas', function (Blueprint $table) {
      $table->id();

      // ---- Pelaku ----
      $table->string('pelaku_tipe', 20);           // super_admin | admin | kelurahan | publik | sistem
      $table->unsignedBigInteger('pelaku_id')->nullable();
      $table->string('pelaku_nama', 255)->nullable();
      $table->string('pelaku_username', 255)->nullable();

      // ---- Aksi ----
      $table->string('aksi', 20);                  // tambah | ubah | hapus | pulihkan

      // ---- Sasaran ----
      $table->string('model', 255);                // App\Models\Berita
      $table->string('model_label', 100);          // Berita
      $table->string('record_id', 100)->nullable();
      $table->string('record_label', 255)->nullable();

      // Rincian kolom yang berubah: {"kolom": {"dari": ..., "menjadi": ...}}
      $table->json('perubahan')->nullable();

      // ---- Konteks permintaan ----
      $table->string('ip_address', 45)->nullable();
      $table->string('metode', 10)->nullable();
      $table->text('url')->nullable();
      $table->text('user_agent')->nullable();

      $table->timestamp('created_at')->nullable();

      // Indeks mengikuti cara halaman log disaring: per waktu, per pelaku,
      // per jenis aksi, dan penelusuran satu record tertentu.
      $table->index('created_at');
      $table->index(['pelaku_tipe', 'pelaku_id']);
      $table->index('aksi');
      $table->index(['model', 'record_id']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('log_aktivitas');
  }
};
