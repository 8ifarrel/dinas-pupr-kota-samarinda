<?php

namespace Tests\Feature\HantuBanyu;

use App\Support\HantuBanyu\FotoPdf;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FotoPdfTest extends TestCase
{
  private string $dir;

  protected function setUp(): void
  {
    parent::setUp();
    $this->dir = sys_get_temp_dir() . '/hb-fotopdf-test-' . getmypid();
    File::deleteDirectory($this->dir);
    File::ensureDirectoryExists($this->dir . '/storage');
    $this->app->useStoragePath($this->dir . '/storage');
  }

  protected function tearDown(): void
  {
    File::deleteDirectory($this->dir);
    parent::tearDown();
  }

  /** JPEG 400x200 empat warna (kiri-atas merah, kanan-atas hijau, kiri-bawah biru, kanan-bawah kuning) + tag EXIF Orientation. */
  private function jpegBerorientasi(int $o): string
  {
    $i = imagecreatetruecolor(400, 200);
    imagefilledrectangle($i, 0, 0, 199, 99, imagecolorallocate($i, 255, 0, 0));
    imagefilledrectangle($i, 200, 0, 399, 99, imagecolorallocate($i, 0, 255, 0));
    imagefilledrectangle($i, 0, 100, 199, 199, imagecolorallocate($i, 0, 0, 255));
    imagefilledrectangle($i, 200, 100, 399, 199, imagecolorallocate($i, 255, 255, 0));
    ob_start();
    imagejpeg($i, null, 95);
    $jpg = ob_get_clean();

    $tiff = 'MM' . chr(0) . chr(42) . pack('N', 8) . pack('n', 1) . pack('n', 0x0112) . pack('n', 3) . pack('N', 1) . pack('n', $o) . chr(0) . chr(0) . pack('N', 0);
    $app1 = chr(0xFF) . chr(0xE1) . pack('n', 8 + strlen($tiff)) . 'Exif' . chr(0) . chr(0) . $tiff;
    $pos = 4 + unpack('n', substr($jpg, 4, 2))[1];
    $path = "{$this->dir}/o{$o}.jpg";
    file_put_contents($path, substr($jpg, 0, $pos) . $app1 . substr($jpg, $pos));

    return $path;
  }

  private function sudut(string $path): string
  {
    $img = imagecreatefromstring(file_get_contents($path));
    [$w, $h] = [imagesx($img), imagesy($img)];
    $warna = function ($fx, $fy) use ($img, $w, $h) {
      $c = imagecolorat($img, (int) floor($w * $fx), (int) floor($h * $fy));
      return ((($c >> 16) & 255) > 128 ? 'R' : '-') . ((($c >> 8) & 255) > 128 ? 'G' : '-') . (($c & 255) > 128 ? 'B' : '-');
    };

    return "{$w}x{$h} " . implode(' ', [$warna(.15, .15), $warna(.85, .15), $warna(.15, .85), $warna(.85, .85)]);
  }

  /** Nilai harapan = cara Chrome menampilkan foto aslinya (diukur langsung di Chrome). */
  public static function orientasiProvider(): array
  {
    return [
      [1, '120x60 R-- -G- --B RG-'],
      [2, '120x60 -G- R-- RG- --B'],
      [3, '120x60 RG- --B -G- R--'],
      [4, '120x60 --B RG- R-- -G-'],
      [5, '30x60 R-- --B -G- RG-'],
      [6, '30x60 --B R-- RG- -G-'],
      [7, '30x60 RG- -G- --B R--'],
      [8, '30x60 -G- RG- R-- --B'],
    ];
  }

  #[DataProvider('orientasiProvider')]
  public function test_salinan_mengikuti_orientasi_exif(int $o, string $harapan): void
  {
    $asli = $this->jpegBerorientasi($o);
    $md5Asli = md5_file($asli);
    $salinan = FotoPdf::path($asli, 60);

    $this->assertNotSame($asli, $salinan);
    $this->assertSame($harapan, $this->sudut($salinan));
    $this->assertSame($md5Asli, md5_file($asli), 'Foto asli tidak boleh berubah');
    $this->assertSame($salinan, FotoPdf::path($asli, 60), 'Permintaan kedua memakai cache');
  }

  public function test_png_transparan_tetap_png_dengan_alpha(): void
  {
    $i = imagecreatetruecolor(300, 300);
    imagesavealpha($i, true);
    imagefill($i, 0, 0, imagecolorallocatealpha($i, 0, 0, 0, 127));
    imagefilledrectangle($i, 100, 100, 199, 199, imagecolorallocate($i, 255, 0, 0));
    imagepng($i, "{$this->dir}/t.png");

    $salinan = FotoPdf::path("{$this->dir}/t.png", 100);
    $this->assertStringEndsWith('.png', $salinan);
    $img = imagecreatefrompng($salinan);
    $this->assertSame(127, (imagecolorat($img, 5, 5) >> 24) & 127, 'Sudut tetap transparan');
  }

  public function test_foto_kecil_dan_berkas_hilang_memakai_aslinya(): void
  {
    $i = imagecreatetruecolor(80, 40);
    imagejpeg($i, "{$this->dir}/kecil.jpg");

    $this->assertSame("{$this->dir}/kecil.jpg", FotoPdf::path("{$this->dir}/kecil.jpg", 60));
    $this->assertSame("{$this->dir}/tidak-ada.jpg", FotoPdf::path("{$this->dir}/tidak-ada.jpg", 60));
  }

  public function test_anggaran_waktu_habis_memakai_aslinya(): void
  {
    $asli = $this->jpegBerorientasi(1);
    request()->attributes->set('hantu_banyu_foto_pdf_detik', 10.0);

    $this->assertSame($asli, FotoPdf::path($asli, 60));
  }
}
