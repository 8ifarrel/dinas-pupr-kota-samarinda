<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Susun ulang status pesanan SILALAD dari empat jadi lima tahap.
 *
 * Masalah rancangan lama: "Belum dikerjakan" menampung dua keadaan yang jauh
 * berbeda - pesanan yang baru masuk dan belum disentuh siapa pun, serta
 * pesanan yang sudah dikonfirmasi dan dijadwalkan. Keduanya tampil sama di
 * daftar admin maupun di halaman pelanggan, sehingga pesanan yang terlantar
 * tidak bisa dibedakan dari yang memang tinggal ditunggu.
 *
 * Selain itu "Sedang dikerjakan" lama sebenarnya bermakna "sudah ditugaskan"
 * (validasinya mewajibkan operator, kendaraan, dan tanggal perintah), bukan
 * "armada sedang menyedot". Karena itu baris lama berstatus "Sedang
 * dikerjakan" dipetakan ke "Dijadwalkan", bukan ke status bernama sama.
 *
 * Pemetaan:
 *   Belum dikerjakan  -> Menunggu konfirmasi
 *   Sedang dikerjakan -> Dijadwalkan          (lihat alasan di atas)
 *   Sudah dikerjakan  -> Selesai
 *   Dibatalkan        -> Dibatalkan
 *
 * Dikenakan ke dua tabel sekaligus: `silalad.status_pengerjaan` (status
 * terkini) dan `silalad_tindak_lanjut.status` (riwayat) - kalau hanya salah
 * satu yang diubah, jejak pesanan lama akan menampilkan label yang sudah
 * tidak dikenal lagi.
 */
return new class extends Migration
{
  /** @var array<string,string> status lama => status baru */
  private const PEMETAAN = [
    'Belum dikerjakan' => 'Menunggu konfirmasi',
    'Sedang dikerjakan' => 'Dijadwalkan',
    'Sudah dikerjakan' => 'Selesai',
  ];

  private const LAMA = ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'];
  private const BARU = ['Menunggu konfirmasi', 'Dijadwalkan', 'Sedang dikerjakan', 'Selesai', 'Dibatalkan'];

  public function up(): void
  {
    // ENUM dilebarkan dulu jadi gabungan lama+baru supaya baris yang ada
    // tetap sah selagi datanya dipindahkan, baru dipersempit di akhir.
    $gabungan = array_values(array_unique(array_merge(self::LAMA, self::BARU)));

    $this->ubahEnum('silalad', 'status_pengerjaan', $gabungan, 'Belum dikerjakan');
    $this->ubahEnum('silalad_tindak_lanjut', 'status', $gabungan);

    foreach (self::PEMETAAN as $lama => $baru) {
      DB::table('silalad')->where('status_pengerjaan', $lama)->update(['status_pengerjaan' => $baru]);
      DB::table('silalad_tindak_lanjut')->where('status', $lama)->update(['status' => $baru]);
    }

    $this->ubahEnum('silalad', 'status_pengerjaan', self::BARU, 'Menunggu konfirmasi');
    $this->ubahEnum('silalad_tindak_lanjut', 'status', self::BARU);
  }

  /**
   * Catatan: pembalikan ini merugi. "Dijadwalkan" dan "Sedang dikerjakan"
   * sama-sama kembali jadi "Sedang dikerjakan", sehingga bedanya hilang dan
   * tidak bisa dipulihkan lagi bila migrasi ini dijalankan maju kembali.
   */
  public function down(): void
  {
    $gabungan = array_values(array_unique(array_merge(self::LAMA, self::BARU)));

    $this->ubahEnum('silalad', 'status_pengerjaan', $gabungan, 'Menunggu konfirmasi');
    $this->ubahEnum('silalad_tindak_lanjut', 'status', $gabungan);

    $balik = [
      'Menunggu konfirmasi' => 'Belum dikerjakan',
      'Dijadwalkan' => 'Sedang dikerjakan',
      'Sedang dikerjakan' => 'Sedang dikerjakan',
      'Selesai' => 'Sudah dikerjakan',
    ];

    foreach ($balik as $baru => $lama) {
      DB::table('silalad')->where('status_pengerjaan', $baru)->update(['status_pengerjaan' => $lama]);
      DB::table('silalad_tindak_lanjut')->where('status', $baru)->update(['status' => $lama]);
    }

    $this->ubahEnum('silalad', 'status_pengerjaan', self::LAMA, 'Belum dikerjakan');
    $this->ubahEnum('silalad_tindak_lanjut', 'status', self::LAMA);
  }

  /**
   * ALTER ... MODIFY ditulis manual karena doctrine/dbal tidak terpasang di
   * proyek ini, sehingga Schema::table()->change() tidak bisa dipakai untuk
   * kolom ENUM.
   */
  private function ubahEnum(string $tabel, string $kolom, array $nilai, ?string $bawaan = null): void
  {
    $daftar = implode(',', array_map(fn($v) => "'" . addslashes($v) . "'", $nilai));
    $sql = "ALTER TABLE `{$tabel}` MODIFY `{$kolom}` ENUM({$daftar}) NOT NULL";

    if ($bawaan !== null) {
      $sql .= " DEFAULT '" . addslashes($bawaan) . "'";
    }

    DB::statement($sql);
  }
};
