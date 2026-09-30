<?php

namespace App\Support\HantuBanyu;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Salinan foto yang diperkecil khusus untuk disisipkan ke PDF.
 *
 * Foto laporan disimpan apa adanya (sering 1280px ke atas, ratusan KB),
 * padahal di PDF hanya tampil setinggi puluhan piksel. Chrome menyisipkan
 * berkas aslinya utuh, sehingga PDF rekap bisa puluhan MB dan lambat dibuat
 * (rawan "Page.printToPDF timed out"). Salinan kecil ini dibuat sekali lalu
 * disimpan di cache; foto asli tidak pernah diubah.
 */
class FotoPdf
{
  /**
   * Batas waktu membuat salinan baru dalam satu permintaan. Ekspor pertama
   * atas ribuan foto yang belum ada di cache bisa memakan puluhan detik dan
   * menabrak max_execution_time; lewat batas ini sisa foto memakai berkas
   * asli (PDF tetap benar, hanya lebih besar) dan cache terisi bertahap di
   * ekspor berikutnya.
   */
  private const ANGGARAN_DETIK = 10.0;

  /**
   * Path berkas yang dipakai sebagai src <img> di PDF.
   *
   * @param  string  $asli  path absolut foto asli
   * @param  int  $tinggiPx  tinggi salinan; pemanggil memakai kira-kira 4x
   *                         tinggi tampil di CSS supaya tetap tajam saat
   *                         dicetak (setara ~380 dpi)
   * @return string path salinan kecil, atau $asli bila berkas tidak ada,
   *                sudah cukup kecil, atau gagal diperkecil
   */
  public static function path(string $asli, int $tinggiPx): string
  {
    if (!is_file($asli) || !extension_loaded('gd')) {
      return $asli;
    }

    $info = @getimagesize($asli);
    if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
      return $asli;
    }

    $orientasi = self::orientasiExif($asli, $info[2]);
    if ($orientasi === null) {
      // Orientasi JPEG tidak bisa dibaca: lebih aman memakai aslinya
      // daripada berisiko foto tampil terputar.
      return $asli;
    }

    // Tinggi TAMPIL setelah rotasi EXIF (orientasi 5-8 menukar sisi).
    $tinggiTampil = $orientasi >= 5 ? $info[0] : $info[1];
    if ($tinggiTampil <= $tinggiPx) {
      return $asli;
    }

    $png = $info[2] === IMAGETYPE_PNG;
    $dir = storage_path('app/cache/hantu-banyu/foto-pdf');
    $tujuan = $dir . '/' . sha1($asli . '|' . filesize($asli) . '|' . filemtime($asli) . '|' . $tinggiPx) . ($png ? '.png' : '.jpg');

    if (is_file($tujuan)) {
      return $tujuan;
    }

    // Dicatat per permintaan (atribut request), bukan properti statis.
    $atribut = request()->attributes;
    $terpakai = (float) $atribut->get('hantu_banyu_foto_pdf_detik', 0.0);
    if ($terpakai >= self::ANGGARAN_DETIK) {
      return $asli;
    }
    $mulai = microtime(true);

    try {
      File::ensureDirectoryExists($dir);
      $sumber = $png ? imagecreatefrompng($asli) : imagecreatefromjpeg($asli);
      if (!$sumber) {
        return $asli;
      }

      $sumber = self::terapkanOrientasi($sumber, $orientasi);
      $lebar = max(1, (int) round(imagesx($sumber) * $tinggiPx / imagesy($sumber)));
      $kecil = imagecreatetruecolor($lebar, $tinggiPx);

      if ($png) {
        imagealphablending($kecil, false);
        imagesavealpha($kecil, true);
      }
      imagecopyresampled($kecil, $sumber, 0, 0, 0, 0, $lebar, $tinggiPx, imagesx($sumber), imagesy($sumber));

      // Tulis ke berkas sementara lalu rename, supaya permintaan PDF lain
      // yang berjalan bersamaan tidak membaca berkas setengah jadi.
      $sementara = $tujuan . '.' . getmypid() . '.tmp';
      $ok = $png ? imagepng($kecil, $sementara, 6) : imagejpeg($kecil, $sementara, 85);

      if (!$ok || !@rename($sementara, $tujuan)) {
        @unlink($sementara);
        return is_file($tujuan) ? $tujuan : $asli;
      }

      return $tujuan;
    } catch (\Throwable $e) {
      Log::warning('FotoPdf: gagal memperkecil ' . $asli . ': ' . $e->getMessage());

      return $asli;
    } finally {
      $atribut->set('hantu_banyu_foto_pdf_detik', $terpakai + (microtime(true) - $mulai));
    }
  }

  /** 1-8 sesuai tag EXIF Orientation; 1 untuk PNG; null bila JPEG tapi EXIF tak bisa dibaca. */
  private static function orientasiExif(string $path, int $tipe): ?int
  {
    if ($tipe !== IMAGETYPE_JPEG) {
      return 1;
    }
    if (!function_exists('exif_read_data')) {
      return null;
    }

    $exif = @exif_read_data($path);
    $o = (int) ($exif['Orientation'] ?? 1);

    return ($o >= 1 && $o <= 8) ? $o : 1;
  }

  /** Putar/cerminkan gambar sesuai orientasi EXIF, seperti yang dilakukan browser. */
  private static function terapkanOrientasi(\GdImage $img, int $o): \GdImage
  {
    // Putar dulu, baru cerminkan: urutan sebaliknya menukar hasil
    // orientasi 5 (transpose) dengan 7 (transverse).
    $sudut = match ($o) {
      3, 4 => 180,
      5, 6 => -90,
      7, 8 => 90,
      default => 0,
    };
    if ($sudut !== 0) {
      $img = imagerotate($img, $sudut, 0);
    }

    if (in_array($o, [2, 4, 5, 7], true)) {
      imageflip($img, IMG_FLIP_HORIZONTAL);
    }

    return $img;
  }
}
