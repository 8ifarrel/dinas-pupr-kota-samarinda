<?php

namespace App\Console\Commands;

use App\Models\LogAktivitas;
use Illuminate\Console\Command;

/**
 * Pemangkas jejak audit lama.
 *
 * Tabel log_aktivitas bertambah terus seumur hidup aplikasi dan tidak pernah
 * menyusut sendiri. Perintah ini dijalankan berkala (mis. lewat penjadwal
 * bulanan) agar basis data tidak membengkak tanpa batas.
 *
 * Contoh:
 *   php artisan log:bersihkan                 -> buang yang lebih tua dari 365 hari
 *   php artisan log:bersihkan --hari=180      -> buang yang lebih tua dari 180 hari
 *   php artisan log:bersihkan --uji-coba      -> hanya menghitung, tidak menghapus
 */
class BersihkanLogAktivitas extends Command
{
  protected $signature = 'log:bersihkan
                          {--hari=365 : Umur maksimal catatan yang dipertahankan}
                          {--uji-coba : Tampilkan jumlahnya saja tanpa benar-benar menghapus}';

  protected $description = 'Membuang catatan log aktivitas yang sudah melewati batas umur simpan';

  public function handle(): int
  {
    $hari = (int) $this->option('hari');

    if ($hari < 1) {
      $this->error('Nilai --hari harus minimal 1.');

      return self::FAILURE;
    }

    $batas = now()->subDays($hari);
    $jumlah = LogAktivitas::where('created_at', '<', $batas)->count();

    if ($jumlah === 0) {
      $this->info("Tidak ada catatan yang lebih tua dari {$hari} hari. Tidak ada yang dihapus.");

      return self::SUCCESS;
    }

    if ($this->option('uji-coba')) {
      $this->warn("[UJI COBA] {$jumlah} catatan sebelum {$batas->format('d M Y')} akan dihapus. Tidak ada yang benar-benar dihapus.");

      return self::SUCCESS;
    }

    // Dihapus bertahap supaya tidak mengunci tabel terlalu lama saat isinya besar.
    $terhapus = 0;
    do {
      $batch = LogAktivitas::where('created_at', '<', $batas)->limit(1000)->delete();
      $terhapus += $batch;
    } while ($batch > 0);

    $this->info("{$terhapus} catatan sebelum {$batas->format('d M Y')} berhasil dihapus.");

    return self::SUCCESS;
  }
}
