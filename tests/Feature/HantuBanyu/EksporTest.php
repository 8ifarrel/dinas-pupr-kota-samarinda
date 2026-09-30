<?php

namespace Tests\Feature\HantuBanyu;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Rekaman ekspor Excel & PDF Hantu Banyu. Excel dibandingkan per sel (nilai,
 * tipe, gaya, lebar kolom, sel gabung); PDF dibandingkan lewat teks hasil
 * pdftotext, jumlah halaman, dan jumlah gambar. Ukuran berkas & dimensi
 * gambar PDF dicatat sebagai metrik (bukan pembanding), karena optimasi
 * foto PDF memang sengaja mengubahnya.
 */
class EksporTest extends HantuBanyuTestCase
{
  protected bool $butuhFoto = true;

  public static function modeProvider(): array
  {
    return [
      'semua' => [['mode' => 'semua']],
      'hari-ini' => [['mode' => 'hari_ini']],
      'rentang' => [['mode' => 'rentang', 'dari_tanggal' => '2026-02-01', 'sampai_tanggal' => '2026-07-15']],
      'rentang-terbalik' => [['mode' => 'rentang', 'dari_tanggal' => '2026-07-15', 'sampai_tanggal' => '2026-02-01']],
      'rentang-satu-hari' => [['mode' => 'rentang', 'dari_tanggal' => '2026-09-30', 'sampai_tanggal' => '2026-09-30']],
      'tahun-2025' => [['mode' => 'tahun', 'tahun' => 2025]],
      'tahun-2026' => [['mode' => 'tahun', 'tahun' => 2026]],
      'bulan' => [['mode' => 'bulan', 'periode_bulan' => '2026-06']],
      'bulan-desember' => [['mode' => 'bulan', 'periode_bulan' => '2025-12']],
      'bulan-kosong-data' => [['mode' => 'bulan', 'periode_bulan' => '2024-01']],
      'bulan-tanpa-isian' => [['mode' => 'bulan']],
      'rentang-tanpa-isian' => [['mode' => 'rentang', 'dari_tanggal' => '2026-01-01']],
      'mode-salah' => [['mode' => 'minggu']],
      'bulan-format-salah' => [['mode' => 'bulan', 'periode_bulan' => '2026-13']],
    ];
  }

  #[DataProvider('modeProvider')]
  public function test_excel_laporan(array $query): void
  {
    $this->rekamExcel('excel-laporan-' . $this->dataName(), route('admin.hantu-banyu.laporan.unduh-excel', $query));
  }

  #[DataProvider('modeProvider')]
  public function test_excel_pemeriksaan_berkala(array $query): void
  {
    $this->rekamExcel('excel-pemeriksaan-' . $this->dataName(), route('admin.hantu-banyu.pemeriksaan-berkala.unduh-excel', $query));
  }

  public static function pdfProvider(): array
  {
    return [
      'laporan-semua' => ['admin.hantu-banyu.laporan.unduh-pdf', ['mode' => 'semua']],
      'laporan-bulan' => ['admin.hantu-banyu.laporan.unduh-pdf', ['mode' => 'bulan', 'periode_bulan' => '2026-06']],
      'laporan-hari-ini' => ['admin.hantu-banyu.laporan.unduh-pdf', ['mode' => 'hari_ini']],
      'laporan-satu' => ['admin.hantu-banyu.laporan.pdf', ['kode' => 'HB-2026-0005']],
      'pemeriksaan-semua' => ['admin.hantu-banyu.pemeriksaan-berkala.unduh-pdf', ['mode' => 'semua']],
      'pemeriksaan-tahun' => ['admin.hantu-banyu.pemeriksaan-berkala.unduh-pdf', ['mode' => 'tahun', 'tahun' => 2026]],
    ];
  }

  #[DataProvider('pdfProvider')]
  public function test_pdf_epanel(string $route, array $query): void
  {
    $this->sebagaiAdmin();
    $this->rekamPdf('pdf-' . $this->dataName(), $this->get(route($route, $query), ['referer' => 'http://localhost/asal']));
  }

  public function test_pdf_bukti_pengaduan(): void
  {
    $this->sebagaiKelurahan();
    $url = URL::temporarySignedRoute('guest.hantu-banyu.pengaduan.pdf', now()->addMinutes(15), ['kode' => 'HB-2026-0007']);
    $this->rekamPdf('pdf-bukti-pengaduan', $this->get($url, ['referer' => 'http://localhost/asal']));
  }

  private function rekamExcel(string $nama, string $url): void
  {
    $this->sebagaiAdmin();
    [$res, $jumlah] = $this->hitungQuery(fn() => $this->get($url, ['referer' => 'http://localhost/asal']));

    if ($res->getStatusCode() !== 200) {
      $this->assertSnapshot($nama . '.txt', $this->ringkasTolak($res));
      return;
    }

    $content = $res->streamedContent();
    $tmp = tempnam(sys_get_temp_dir(), 'hbx') . '.xlsx';
    file_put_contents($tmp, $content);
    $isi = $this->serialisasiExcel($tmp);
    @unlink($tmp);

    $this->assertSnapshot($nama . '.json', json_encode([
      'status' => $res->getStatusCode(),
      'content_type' => $res->headers->get('Content-Type'),
      'disposition' => $res->headers->get('Content-Disposition'),
      'isi' => $isi,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $this->assertQueryTidakBertambah($nama, $jumlah);
    $this->catatMetrik($nama, ['bytes' => strlen($content)]);
  }

  private function rekamPdf(string $nama, $res): void
  {
    if ($res->getStatusCode() !== 200) {
      $this->assertSnapshot($nama . '.txt', $this->ringkasTolak($res));
      return;
    }

    $file = $res->baseResponse->getFile()->getPathname();
    $bytes = File::get($file);

    $txt = tempnam(sys_get_temp_dir(), 'hbp');
    exec('pdftotext -layout -enc UTF-8 ' . escapeshellarg($file) . ' ' . escapeshellarg($txt), $o, $kode);
    // Di test, respons tidak benar-benar dikirim sehingga deleteFileAfterSend
    // tidak berjalan; bersihkan sendiri berkas sementaranya.
    @unlink($file);
    $this->assertSame(0, $kode, 'pdftotext gagal');
    $teks = File::get($txt);
    @unlink($txt);

    preg_match_all('#/Subtype\s*/Image.*?/Width\s+(\d+)\s*/Height\s+(\d+)#s', $bytes, $img, PREG_SET_ORDER);
    preg_match_all('#/Type\s*/Page[^s]#', $bytes, $hal);

    $this->assertSnapshot($nama . '.json', json_encode([
      'status' => $res->getStatusCode(),
      'content_type' => $res->headers->get('Content-Type'),
      'disposition' => $res->headers->get('Content-Disposition'),
      'halaman' => count($hal[0]),
      'gambar' => count($img),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $this->assertSnapshot($nama . '.txt', $teks);

    $this->catatMetrik($nama, [
      'bytes' => strlen($bytes),
      'dimensi_gambar' => array_count_values(array_map(fn($m) => $m[1] . 'x' . $m[2], $img)),
    ]);
  }

  private function ringkasTolak($res): string
  {
    return json_encode([
      'status' => $res->getStatusCode(),
      'redirect' => $res->headers->get('Location'),
      'error' => session('error'),
      'errors' => session('errors')?->getBag('default')->toArray(),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  }

  private function serialisasiExcel(string $path): array
  {
    $book = IOFactory::load($path);
    $hasil = [];

    foreach ($book->getAllSheets() as $sheet) {
      $sel = [];
      foreach ($sheet->getCellCollection()->getCoordinates() as $coord) {
        $c = $sheet->getCell($coord);
        $style = $sheet->getStyle($coord);
        $sel[$coord] = [
          'v' => $c->getValue(),
          't' => $c->getDataType(),
          'b' => $style->getFont()->getBold(),
          'i' => $style->getFont()->getItalic(),
          'sz' => $style->getFont()->getSize(),
          'wrap' => $style->getAlignment()->getWrapText(),
        ];
      }
      ksort($sel, SORT_NATURAL);

      $kolom = [];
      foreach ($sheet->getColumnDimensions() as $k => $d) {
        $kolom[$k] = ['w' => round($d->getWidth(), 4), 'auto' => $d->getAutoSize()];
      }
      ksort($kolom, SORT_NATURAL);

      $hasil[$sheet->getTitle()] = [
        'merge' => array_values($sheet->getMergeCells()),
        'freeze' => $sheet->getFreezePane(),
        'kolom' => $kolom,
        'sel' => $sel,
      ];
    }

    return $hasil;
  }

  private function catatMetrik(string $nama, array $data): void
  {
    $dir = base_path('tests/Snapshots/HantuBanyu/_metrik-' . (getenv('SNAPSHOT_RECORD') === '1' ? 'sebelum' : 'sesudah'));
    File::ensureDirectoryExists($dir);
    File::put($dir . '/' . $nama . '.json', json_encode($data, JSON_PRETTY_PRINT));
  }
}
