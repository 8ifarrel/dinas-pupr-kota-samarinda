<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Riwayat perubahan status pesanan SILALAD.
 *
 * Sebelumnya status hanya berupa satu kolom di tabel `silalad` yang ditimpa
 * tiap kali diubah, sehingga tidak ada jejak kapan pesanan dikonfirmasi,
 * kapan dikerjakan, atau kenapa dibatalkan. Polanya mengikuti
 * `hantu_banyu_laporan_tindak_lanjut`: tiap perubahan status jadi satu baris
 * baru, tidak pernah menimpa baris sebelumnya.
 *
 * Kolom `silalad.status_pengerjaan` tetap dipertahankan sebagai status
 * terkini supaya penyaringan dan statistik tidak perlu menghitung ulang
 * riwayat tiap kali; tabel ini yang menyimpan perjalanannya.
 */
return new class extends Migration
{
  public function up(): void
  {
    Schema::create('silalad_tindak_lanjut', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('silalad_id')->index();
      $table->foreign('silalad_id')->references('id')->on('silalad')->onDelete('cascade');
      $table->enum('status', [
        'Belum dikerjakan',
        'Sedang dikerjakan',
        'Sudah dikerjakan',
        'Dibatalkan',
      ]);
      $table->text('keterangan')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    // Pesanan yang sudah ada belum punya riwayat sama sekali. Dibuatkan satu
    // baris awal memakai status dan waktu pendaftarannya masing-masing,
    // supaya riwayatnya tidak kosong dan status terkini tetap cocok.
    $pesanan = DB::table('silalad')->get(['id', 'status_pengerjaan', 'created_at']);

    foreach ($pesanan as $p) {
      DB::table('silalad_tindak_lanjut')->insert([
        'silalad_id' => $p->id,
        'status' => $p->status_pengerjaan,
        'keterangan' => 'Riwayat awal dicatat saat fitur pemantauan status ditambahkan.',
        'created_at' => $p->created_at,
        'updated_at' => $p->created_at,
      ]);
    }
  }

  public function down(): void
  {
    Schema::dropIfExists('silalad_tindak_lanjut');
  }
};
