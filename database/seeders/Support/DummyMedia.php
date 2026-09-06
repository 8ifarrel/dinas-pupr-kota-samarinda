<?php

namespace Database\Seeders\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Pembuat berkas dummy untuk seeder.
 *
 * Berkas ditulis ke disk "public" pada path yang sama persis dengan yang dipakai
 * controller saat unggahan asli, sehingga struktur folder storage hasil seeding
 * mencerminkan struktur di produksi.
 */
class DummyMedia
{
  /** Warna latar per jenis konten agar antar fitur mudah dibedakan saat dilihat. */
  private const PALET = [
    'berita' => [37, 99, 235],
    'slider' => [15, 118, 110],
    'album' => [161, 98, 7],
    'partner' => [71, 85, 105],
    'pegawai' => [30, 58, 138],
    'struktur' => [109, 40, 217],
    'hantu-banyu' => [180, 83, 9],
    'dokumen' => [190, 18, 60],
  ];

  /**
   * Tulis satu gambar PNG berlabel. Mengembalikan path relatif disk "public"
   * agar bisa langsung disimpan ke kolom database.
   */
  public static function gambar(string $path, int $lebar, int $tinggi, string $label, string $palet = 'berita'): string
  {
    [$r, $g, $b] = self::PALET[$palet] ?? self::PALET['berita'];

    $img = imagecreatetruecolor($lebar, $tinggi);
    $latar = imagecolorallocate($img, $r, $g, $b);
    $terang = imagecolorallocate($img, min($r + 45, 255), min($g + 45, 255), min($b + 45, 255));
    $putih = imagecolorallocate($img, 255, 255, 255);

    imagefilledrectangle($img, 0, 0, $lebar, $tinggi, $latar);
    // Garis diagonal tipis supaya jelas ini gambar placeholder, bukan foto asli.
    for ($i = -$tinggi; $i < $lebar; $i += 24) {
      imageline($img, $i, 0, $i + $tinggi, $tinggi, $terang);
    }
    imagerectangle($img, 4, 4, $lebar - 5, $tinggi - 5, $putih);

    self::tulisTengah($img, $label, $lebar, $tinggi, $putih);

    ob_start();
    imagepng($img);
    $biner = ob_get_clean();
    imagedestroy($img);

    Storage::disk('public')->put($path, $biner);

    return $path;
  }

  /** Tulis PDF satu halaman A4 berisi judul. Mengembalikan path relatif disk "public". */
  public static function pdf(string $path, string $judul): string
  {
    Storage::disk('public')->put($path, self::binerPdf($judul));

    return $path;
  }

  private static function tulisTengah($img, string $teks, int $lebar, int $tinggi, int $warna): void
  {
    $font = 5;
    $baris = str_split($teks, (int) max(1, floor($lebar / (imagefontwidth($font) + 1))));
    $baris = array_slice($baris, 0, 3);
    $tinggiBlok = count($baris) * (imagefontheight($font) + 4);
    $y = (int) (($tinggi - $tinggiBlok) / 2);

    foreach ($baris as $b) {
      $x = (int) (($lebar - imagefontwidth($font) * strlen($b)) / 2);
      imagestring($img, $font, max($x, 2), $y, $b, $warna);
      $y += imagefontheight($font) + 4;
    }
  }

  /** Rakit PDF minimal yang valid; offset xref dihitung agar berkas benar-benar terbuka. */
  private static function binerPdf(string $judul): string
  {
    $judul = preg_replace('/[^\x20-\x7E]/', ' ', $judul);
    $bs = chr(92);
    $judul = str_replace([$bs, chr(40), chr(41)], [$bs.$bs, $bs.chr(40), $bs.chr(41)], $judul);

    $isi = "BT /F1 16 Tf 60 780 Td ($judul) Tj ET\n"
      . "BT /F1 11 Tf 60 750 Td (Berkas contoh hasil seeder - Dinas PUPR Kota Samarinda.) Tj ET";

    $objek = [
      "<</Type/Catalog/Pages 2 0 R>>",
      "<</Type/Pages/Kids[3 0 R]/Count 1>>",
      "<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>",
      "<</Length " . strlen($isi) . ">>\nstream\n$isi\nendstream",
      "<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>",
    ];

    $pdf = "%PDF-1.4\n";
    $offset = [];
    foreach ($objek as $i => $o) {
      $offset[$i] = strlen($pdf);
      $pdf .= ($i + 1) . " 0 obj\n$o\nendobj\n";
    }

    $awalXref = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objek) + 1) . "\n0000000000 65535 f \n";
    foreach ($offset as $o) {
      $pdf .= sprintf("%010d 00000 n \n", $o);
    }
    $pdf .= "trailer\n<</Size " . (count($objek) + 1) . "/Root 1 0 R>>\nstartxref\n$awalXref\n%%EOF";

    return $pdf;
  }
}
