<?php

namespace Tests\Feature\HantuBanyu;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\Support\HantuBanyu\HantuBanyuFixture;
use Tests\TestCase;

/**
 * Dasar test "golden master" Hantu Banyu: merekam keluaran saat ini ke
 * tests/Snapshots/HantuBanyu lalu memastikan keluaran berikutnya identik.
 *
 * Rekam ulang snapshot hanya dengan SNAPSHOT_RECORD=1 (dilakukan sekali
 * sebelum optimasi). Tanpa itu, snapshot yang belum ada dianggap gagal.
 */
abstract class HantuBanyuTestCase extends TestCase
{
  use RefreshDatabase;

  protected array $akun;
  protected ?string $publicRoot = null;

  /** Butuh berkas foto nyata (mis. untuk PDF)? */
  protected bool $butuhFoto = false;

  protected function setUp(): void
  {
    parent::setUp();

    HantuBanyuFixture::pastikanDatabaseTest();
    Carbon::setTestNow(HantuBanyuFixture::SEKARANG);
    $this->withoutVite();

    if ($this->butuhFoto) {
      $this->publicRoot = sys_get_temp_dir() . '/hantu-banyu-test-public-' . getmypid();
      File::deleteDirectory($this->publicRoot);
      File::ensureDirectoryExists($this->publicRoot);
      $this->app->usePublicPath($this->publicRoot);
      // Cache thumbnail & PDF sementara ikut ke folder sementara, bukan storage asli.
      File::ensureDirectoryExists($this->publicRoot . '-storage');
      $this->app->useStoragePath($this->publicRoot . '-storage');
    }

    $this->akun = HantuBanyuFixture::seed(36, $this->publicRoot);
  }

  protected function tearDown(): void
  {
    if ($this->publicRoot) {
      File::deleteDirectory($this->publicRoot);
      File::deleteDirectory($this->publicRoot . '-storage');
    }
    Carbon::setTestNow();

    parent::tearDown();
  }

  protected function sebagaiAdmin(): static
  {
    return $this->actingAs(\App\Models\User::find($this->akun['admin_id']), 'web');
  }

  protected function sebagaiAdminBiasa(): static
  {
    return $this->actingAs(\App\Models\User::find($this->akun['admin_biasa_id']), 'web');
  }

  protected function sebagaiKelurahan(): static
  {
    return $this->actingAs(\App\Models\UserKelurahan::find($this->akun['kelurahan_user_id']), 'kelurahan');
  }

  /** Jalankan $aksi sambil menghitung query yang dieksekusi. */
  protected function hitungQuery(callable $aksi): array
  {
    DB::flushQueryLog();
    DB::enableQueryLog();
    $hasil = $aksi();
    $jumlah = count(DB::getQueryLog());
    DB::disableQueryLog();

    return [$hasil, $jumlah];
  }

  protected static function normalisasiHtml(string $html): string
  {
    $html = preg_replace('/(name="_token"\s+value=")[^"]*"/', '$1TOKEN"', $html);
    $html = preg_replace('/(<meta name="csrf-token" content=")[^"]*"/', '$1TOKEN"', $html);

    return $html;
  }

  protected function assertSnapshot(string $nama, string $isi): void
  {
    $path = base_path('tests/Snapshots/HantuBanyu/' . $nama);

    if (getenv('SNAPSHOT_RECORD') === '1') {
      File::ensureDirectoryExists(dirname($path));
      File::put($path, $isi);
      $this->addToAssertionCount(1);

      return;
    }

    $this->assertFileExists($path, "Snapshot {$nama} belum direkam.");
    $this->assertSame(File::get($path), $isi, "Keluaran berbeda dari snapshot {$nama}.");
  }

  /**
   * Jumlah query dicatat sebagai baseline; setelah optimasi tidak boleh
   * bertambah. Angka sesudahnya ditulis ke berkas .now untuk laporan.
   */
  protected function assertQueryTidakBertambah(string $nama, int $jumlah): void
  {
    $path = base_path('tests/Snapshots/HantuBanyu/' . $nama . '.queries');

    if (getenv('SNAPSHOT_RECORD') === '1') {
      File::ensureDirectoryExists(dirname($path));
      File::put($path, (string) $jumlah);
      $this->addToAssertionCount(1);

      return;
    }

    $baseline = (int) File::get($path);
    $this->assertLessThanOrEqual($baseline, $jumlah, "Jumlah query {$nama} naik dari {$baseline} ke {$jumlah}.");
    $sekarang = base_path('tests/Snapshots/HantuBanyu/_query-sekarang/' . $nama);
    File::ensureDirectoryExists(dirname($sekarang));
    File::put($sekarang, (string) $jumlah);
  }
}
