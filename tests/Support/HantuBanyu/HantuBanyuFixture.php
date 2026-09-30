<?php

namespace Tests\Support\HantuBanyu;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

/**
 * Data uji Hantu Banyu yang deterministik (tanpa acak, waktu tetap), dipakai
 * bersama oleh feature test, uji browser, dan skrip benchmark supaya hasil
 * sebelum/sesudah optimasi bisa dibandingkan persis.
 *
 * Sengaja memakai DB::table (bukan model) agar observer, penomoran otomatis,
 * dan timestamp otomatis tidak ikut campur.
 */
class HantuBanyuFixture
{
  public const SEKARANG = '2026-09-30 10:00:00';
  public const PASSWORD = 'rahasia-uji-123';

  private const STATUS = [
    'pending', 'diterima', 'menunggu_survei', 'sudah_disurvei',
    'menunggu_jadwal_pengerjaan', 'sedang_dikerjakan', 'selesai',
  ];
  private const JENIS = ['darurat', 'biasa', 'rutin'];
  private const JALAN = [
    'Jalan Pahlawan', 'Jalan Juanda', 'Jalan Antasari', 'Jalan Siradj Salman', 'Jalan KH. Wahid Hasyim',
    'Jalan Gatot Subroto', 'Jalan Dr. Soetomo', 'Jalan Agus Salim', 'Jalan Basuki Rahmat', 'Jalan Cendana',
    'Jalan Ahmad Yani', 'Jalan Pramuka', 'Jalan Suryanata', 'Jalan Merdeka', 'Jalan Lambung Mangkurat',
  ];

  /** Penghitung id eksplisit: rollback transaksi test tidak mereset AUTO_INCREMENT. */
  private static int $idTl = 0;
  private static array $idFoto = [];

  /** Pastikan tidak pernah menulis ke database selain database test. */
  public static function pastikanDatabaseTest(): void
  {
    $nama = DB::connection()->getDatabaseName();
    if ($nama !== 'pupr_smr_test') {
      throw new RuntimeException("Fixture Hantu Banyu hanya boleh dijalankan di pupr_smr_test, bukan {$nama}.");
    }
  }

  /**
   * @param  int  $jumlahLaporan  jumlah laporan aktif (belum termasuk 1 laporan terhapus)
   * @param  string|null  $publicRoot  bila diisi, berkas foto dibuat di {$publicRoot}/storage/...
   * @return array{admin_id:int,admin_biasa_id:int,kelurahan_user_id:int,kelurahan_id:int}
   */
  public static function seed(int $jumlahLaporan = 36, ?string $publicRoot = null, int $jumlahPemeriksaan = 14): array
  {
    self::pastikanDatabaseTest();
    $now = Carbon::parse(self::SEKARANG);

    DB::table('kecamatan')->insert([
      ['id' => 1, 'nama' => 'Samarinda Ulu'],
      ['id' => 2, 'nama' => 'Samarinda Ilir'],
      ['id' => 3, 'nama' => 'Sungai Kunjang'],
    ]);
    DB::table('kelurahan')->insert([
      ['id' => 1, 'nama' => 'Air Putih', 'kecamatan_id' => 1],
      ['id' => 2, 'nama' => 'Sidodadi', 'kecamatan_id' => 1],
      ['id' => 3, 'nama' => 'Sidomulyo', 'kecamatan_id' => 2],
      ['id' => 4, 'nama' => 'Pelita', 'kecamatan_id' => 2],
      ['id' => 5, 'nama' => 'Loa Bakung', 'kecamatan_id' => 3],
      ['id' => 6, 'nama' => 'Karang Asam Ulu', 'kecamatan_id' => 3],
    ]);

    $adminId = DB::table('users')->insertGetId([
      'id' => 1, 'fullname' => 'Super Admin', 'name' => 'super_admin', 'password' => Hash::make(self::PASSWORD),
      'is_super_admin' => 1, 'created_at' => $now, 'updated_at' => $now,
    ]);
    $adminBiasaId = DB::table('users')->insertGetId([
      'id' => 2, 'fullname' => 'Admin Biasa', 'name' => 'admin_biasa', 'password' => Hash::make(self::PASSWORD),
      'is_super_admin' => 0, 'created_at' => $now, 'updated_at' => $now,
    ]);
    $kelurahanUserId = DB::table('users_kelurahan')->insertGetId([
      'id' => 1, 'kelurahan_id' => 1, 'fullname' => 'Operator Air Putih', 'name' => 'air_putih',
      'password' => Hash::make(self::PASSWORD), 'created_at' => $now, 'updated_at' => $now,
    ]);

    self::$idTl = 0;
    self::$idFoto = ['hantu_banyu_laporan_foto' => 0, 'hantu_banyu_laporan_tindak_lanjut_foto' => 0];
    $fotoSumber = $publicRoot ? self::siapkanFotoSumber() : null;

    for ($i = 0; $i < $jumlahLaporan + 1; $i++) {
      self::buatLaporan($i, $now, $adminId, $publicRoot, $fotoSumber, $i === $jumlahLaporan);
    }

    DB::table('hantu_banyu_laporan_counter')->insert(['tahun' => 2026, 'terakhir' => $jumlahLaporan + 1]);

    for ($i = 0; $i < $jumlahPemeriksaan; $i++) {
      self::buatPemeriksaan($i, $now);
    }

    return [
      'admin_id' => $adminId,
      'admin_biasa_id' => $adminBiasaId,
      'kelurahan_user_id' => $kelurahanUserId,
      'kelurahan_id' => 1,
    ];
  }

  private static function buatLaporan(int $i, Carbon $now, int $adminId, ?string $publicRoot, ?array $fotoSumber, bool $terhapus): void
  {
    $kelurahanId = ($i % 6) + 1;
    $kecamatanId = intdiv($kelurahanId - 1, 2) + 1;
    // Laporan pertama masuk hari ini; sisanya mundur 9 hari 5 jam per langkah
    // sehingga rentangnya melewati pergantian tahun.
    $masuk = $i === 0 ? $now->copy()->setTime(8, 15) : $now->copy()->subDays($i * 9)->subHours($i * 5 % 24)->subMinutes($i * 7 % 60);
    $kode = sprintf('HB-%d-%04d', $masuk->year, $i + 1);
    $admin = $i % 4 === 0;

    $pelaporId = DB::table('hantu_banyu_pelapor')->insertGetId([
      'id' => $i + 1,
      'nama_lengkap' => 'Pelapor Uji ' . ($i + 1),
      'kelurahan_asal_id' => $kelurahanId,
      'alamat' => 'RT ' . (($i % 12) + 1) . ', Samarinda',
      'nomor_telepon' => '0812' . str_pad((string) (3000000 + $i * 7919), 8, '0', STR_PAD_LEFT),
      'created_at' => $masuk, 'updated_at' => $masuk,
    ]);

    $laporanId = DB::table('hantu_banyu_laporan')->insertGetId([
      'id' => $i + 1,
      'kode' => $kode,
      'pelapor_id' => $pelaporId,
      'dibuat_oleh_tipe' => $admin ? 'admin' : 'kelurahan',
      'dibuat_oleh_user_id' => $admin ? $adminId : null,
      'nama_jalan' => self::JALAN[$i % count(self::JALAN)] . ($i >= count(self::JALAN) ? ' Gg. ' . $i : ''),
      'kecamatan_id' => $kecamatanId,
      'kelurahan_id' => $kelurahanId,
      'latitude' => sprintf('%.7f', -0.4600 - $i * 0.0013),
      'longitude' => sprintf('%.7f', 117.1300 + ($i % 9) * 0.0021),
      'detail_lokasi' => 'Depan rumah nomor ' . ($i + 3) . ', dekat masjid.',
      'deskripsi_pengaduan' => "Saluran tersumbat sampah dan sedimen di titik ke-{$i}.\nAir meluap ke badan jalan saat hujan deras.",
      'created_at' => $masuk,
      'updated_at' => $masuk,
      'deleted_at' => $terhapus ? $now->copy()->subDay() : null,
    ]);

    // Tahap tercapai 0..6; tiap kelipatan 10 ditutup langsung pending -> selesai.
    $tutupLangsung = $i % 10 === 9;
    $tahap = $tutupLangsung ? [0, 6] : range(0, $i % 7);
    $jenis = count($tahap) === 1 ? 'belum_diklasifikasikan' : self::JENIS[$i % 3];

    // Satu laporan sengaja disisipkan dengan urutan id tindak lanjut tidak
    // searah urutan tahap, supaya "tindak lanjut terakhir (MAX id)" di sisi
    // publik dan "tahap terjauh" di e-panel sama-sama teruji.
    if ($i === 5) {
      $tahap = [0, 1, 2, 3, 5, 4];
    }

    foreach ($tahap as $urut => $t) {
      $waktu = $masuk->copy()->addHours(6 * ($urut + 1));
      $tlId = DB::table('hantu_banyu_laporan_tindak_lanjut')->insertGetId([
        'id' => ++self::$idTl,
        'laporan_id' => $laporanId,
        'status' => self::STATUS[$t],
        'deskripsi' => 'Catatan tahap ' . self::STATUS[$t] . " untuk laporan {$kode}.",
        'jenis' => $jenis,
        'created_at' => $waktu,
        'updated_at' => $waktu,
      ]);

      if ($t >= 3 && $i % 2 === 0) {
        self::buatFoto('hantu_banyu_laporan_tindak_lanjut_foto', 'tindak_lanjut_id', $tlId, "hantu-banyu/{$kode}/tindak_lanjut/tl{$tlId}.jpg", $waktu, $publicRoot, $fotoSumber, $t);
      }
    }

    $jumlahFoto = ($i % 3) + 1;
    for ($f = 1; $f <= $jumlahFoto; $f++) {
      self::buatFoto('hantu_banyu_laporan_foto', 'laporan_id', $laporanId, "hantu-banyu/{$kode}/foto_laporan/foto{$f}.jpg", $masuk, $publicRoot, $fotoSumber, $i + $f);
    }
  }

  private static function buatFoto(string $tabel, string $fk, int $id, string $path, Carbon $waktu, ?string $publicRoot, ?array $fotoSumber, int $varian): void
  {
    DB::table($tabel)->insert(['id' => ++self::$idFoto[$tabel], $fk => $id, 'foto' => $path, 'created_at' => $waktu, 'updated_at' => $waktu]);

    if ($publicRoot) {
      $tujuan = $publicRoot . '/storage/' . $path;
      @mkdir(dirname($tujuan), 0777, true);
      copy($fotoSumber[$varian % count($fotoSumber)], $tujuan);
    }
  }

  /** Beberapa JPEG 1280x960 (ukuran setara foto asli di produksi), dibuat sekali lalu disalin. */
  private static function siapkanFotoSumber(): array
  {
    $dir = sys_get_temp_dir() . '/hantu-banyu-fixture-foto';
    @mkdir($dir, 0777, true);
    $hasil = [];

    foreach ([[40, 110, 160], [150, 90, 40], [60, 140, 70]] as $n => [$r, $g, $b]) {
      $file = "{$dir}/sumber{$n}.jpg";
      if (!is_file($file)) {
        $img = imagecreatetruecolor(1280, 960);
        for ($y = 0; $y < 960; $y += 4) {
          for ($x = 0; $x < 1280; $x += 4) {
            $v = ($x * 7 + $y * 13 + (($x * $y) % 97)) % 90;
            imagefilledrectangle($img, $x, $y, $x + 3, $y + 3, imagecolorallocate($img, ($r + $v) % 256, ($g + $v * 2) % 256, ($b + $v) % 256));
          }
        }
        imagejpeg($img, $file, 88);
        imagedestroy($img);
      }
      $hasil[] = $file;
    }

    return $hasil;
  }

  private static function buatPemeriksaan(int $i, Carbon $now): void
  {
    $kelurahanId = ($i % 6) + 1;
    $tinggi = [1.20, 0.80, 0.55, 1.50][$i % 4];
    $tanggal = $i === 0 ? $now->copy() : $now->copy()->subDays($i * 23);

    DB::table('hantu_banyu_pemeriksaan_berkala')->insert([
      'id' => $i + 1,
      'tanggal_pemeriksaan' => $tanggal->toDateString(),
      'kecamatan_id' => intdiv($kelurahanId - 1, 2) + 1,
      'kelurahan_id' => $kelurahanId,
      'nama_jalan' => self::JALAN[($i * 2) % count(self::JALAN)],
      'nama_ruas_saluran' => ['primer', 'sekunder', 'tersier'][$i % 3],
      'dimensi_lebar_m' => [2.10, 1.20, 0.60, 1.80][$i % 4],
      'dimensi_tinggi_m' => $tinggi,
      'kondisi_fisik_struktur' => 'Kondisi dinding uji ke-' . $i,
      'tingkat_sedimentasi_sampah_cm' => round($tinggi * 100 * [8, 22, 47][$i % 3] / 100, 1),
      'status_aliran_air' => ['lancar', 'kurang_lancar', 'tersumbat_sebagian', 'macet_total'][$i % 4],
      'tindakan_pemeliharaan' => 'Tindakan uji ke-' . $i,
      'hambatan_kendala' => 'Hambatan uji ke-' . $i,
      'rekomendasi_tindak_lanjut' => 'Rekomendasi uji ke-' . $i,
      'created_at' => $tanggal,
      'updated_at' => $tanggal,
    ]);
  }
}
