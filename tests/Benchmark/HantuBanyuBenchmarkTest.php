<?php

namespace Tests\Benchmark;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\Support\HantuBanyu\HantuBanyuFixture;
use Tests\TestCase;

/**
 * Benchmark Hantu Banyu (bukan bagian suite biasa). Mengukur waktu (median),
 * puncak memori, jumlah query, dan ukuran respons tiap endpoint, lalu
 * menyimpannya ke tests/Snapshots/HantuBanyu/_bench/{BENCH_LABEL}.json.
 *
 *   BENCH_LABEL=00-sebelum php artisan test tests/Benchmark
 */
class HantuBanyuBenchmarkTest extends TestCase
{
  use RefreshDatabase;

  private const ULANG = 5;
  private array $hasil = [];

  protected function setUp(): void
  {
    parent::setUp();
    HantuBanyuFixture::pastikanDatabaseTest();
    Carbon::setTestNow(HantuBanyuFixture::SEKARANG);
    $this->withoutVite();
  }

  public function test_halaman_dan_excel_data_besar(): void
  {
    $akun = HantuBanyuFixture::seed(1500, null, 400);
    $admin = \App\Models\User::find($akun['admin_id']);
    $kel = \App\Models\UserKelurahan::find($akun['kelurahan_user_id']);

    $this->actingAs($admin, 'web');
    $this->ukur('peta-sebaran (admin)', '/hantu-banyu/peta-sebaran');
    $this->ukur('daftar-pengaduan (admin)', '/hantu-banyu/pengaduan/lihat');
    $this->ukur('daftar-pengaduan urut terlama', '/hantu-banyu/pengaduan/lihat?sort=oldest&page=3');
    $this->ukur('statistik publik (admin)', '/hantu-banyu');
    $this->ukur('statistik e-panel', '/e-panel/hantu-banyu/statistik-laporan');
    $this->ukur('e-panel daftar laporan', '/e-panel/hantu-banyu/laporan');
    $this->ukur('excel laporan semua', '/e-panel/hantu-banyu/laporan/unduh-excel?mode=semua', 3);
    $this->ukur('excel laporan tahun 2026', '/e-panel/hantu-banyu/laporan/unduh-excel?mode=tahun&tahun=2026', 3);
    $this->ukur('excel pemeriksaan semua', '/e-panel/hantu-banyu/pemeriksaan-berkala/unduh-excel?mode=semua', 3);

    $this->app['auth']->forgetGuards();
    $this->actingAs($kel, 'kelurahan');
    $this->ukur('peta-sebaran (kelurahan)', '/hantu-banyu/peta-sebaran');
    $this->ukur('statistik publik (kelurahan)', '/hantu-banyu');

    $this->simpan('data-besar');
    $this->assertTrue(true);
  }

  public function test_pdf_dengan_foto(): void
  {
    $public = sys_get_temp_dir() . '/hantu-banyu-bench-public';
    File::deleteDirectory($public);
    File::deleteDirectory($public . '-storage');
    File::ensureDirectoryExists($public . '-storage');
    $this->app->usePublicPath($public);
    $this->app->useStoragePath($public . '-storage');
    $akun = HantuBanyuFixture::seed(36, $public);
    $this->actingAs(\App\Models\User::find($akun['admin_id']), 'web');

    $this->ukur('pdf laporan semua (36 laporan)', '/e-panel/hantu-banyu/laporan/unduh-pdf?mode=semua', 2);
    $this->ukur('pdf satu laporan', '/e-panel/hantu-banyu/laporan/HB-2026-0005/pdf', 2);
    $this->ukur('pdf pemeriksaan semua', '/e-panel/hantu-banyu/pemeriksaan-berkala/unduh-pdf?mode=semua', 2);

    $this->app['auth']->forgetGuards();
    $this->actingAs(\App\Models\UserKelurahan::find($akun['kelurahan_user_id']), 'kelurahan');
    $url = \Illuminate\Support\Facades\URL::temporarySignedRoute('guest.hantu-banyu.pengaduan.pdf', now()->addMinutes(15), ['kode' => 'HB-2026-0007']);
    $this->ukur('pdf bukti pengaduan', $url, 2);

    File::deleteDirectory($public);
    File::deleteDirectory($public . '-storage');
    $this->simpan('pdf');
    $this->assertTrue(true);
  }

  private function ukur(string $nama, string $url, int $ulang = self::ULANG): void
  {
    $waktu = [];
    $memori = 0;
    $query = 0;
    $ukuran = 0;
    $status = 0;

    for ($i = 0; $i < $ulang; $i++) {
      gc_collect_cycles();
      $awalMem = memory_get_usage();
      memory_reset_peak_usage();
      DB::flushQueryLog();
      DB::enableQueryLog();

      $mulai = hrtime(true);
      $res = $this->get($url);
      $isi = $this->isi($res);
      $waktu[] = (hrtime(true) - $mulai) / 1e6;

      $query = count(DB::getQueryLog());
      DB::disableQueryLog();
      $memori = max($memori, memory_get_peak_usage() - $awalMem);
      $ukuran = strlen($isi);
      $status = $res->getStatusCode();
      unset($res, $isi);
    }

    sort($waktu);
    $this->hasil[$nama] = [
      'status' => $status,
      'ms_median' => round($waktu[intdiv(count($waktu), 2)], 1),
      'ms_min' => round($waktu[0], 1),
      'puncak_memori_mb' => round($memori / 1048576, 2),
      'query' => $query,
      'ukuran_kb' => round($ukuran / 1024, 1),
    ];
  }

  private function isi($res): string
  {
    $base = $res->baseResponse;
    if ($base instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
      $path = $base->getFile()->getPathname();
      $isi = file_get_contents($path);
      @unlink($path);
      return $isi;
    }
    if ($base instanceof \Symfony\Component\HttpFoundation\StreamedResponse) {
      return $res->streamedContent();
    }
    return (string) $res->getContent();
  }

  private function simpan(string $bagian): void
  {
    $label = getenv('BENCH_LABEL') ?: 'tanpa-label';
    $path = base_path("tests/Snapshots/HantuBanyu/_bench/{$label}.json");
    File::ensureDirectoryExists(dirname($path));
    $lama = is_file($path) ? json_decode(File::get($path), true) : [];
    $lama[$bagian] = $this->hasil;
    File::put($path, json_encode($lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fwrite(STDERR, "\n[{$label}] " . json_encode($this->hasil, JSON_UNESCAPED_UNICODE) . "\n");
  }
}
