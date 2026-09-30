<?php

namespace Tests\Feature\HantuBanyu;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Rekaman perilaku pemanggilan geocoding (reverse-geocode + fallback
 * Overpass) dan verifikasi koordinat saat menyimpan laporan (web & API),
 * memakai server Nominatim/Overpass palsu lokal (lihat server-geo-palsu.php).
 * Isi respons harus identik; jumlah panggilan eksternal hanya boleh turun.
 */
class GeocodingTest extends HantuBanyuTestCase
{
  private const PORT = 8299;

  /** @var resource|null */
  private static $server = null;
  private static string $log = '';

  public static function setUpBeforeClass(): void
  {
    parent::setUpBeforeClass();

    self::$log = sys_get_temp_dir() . '/hb-geo-palsu-' . getmypid() . '.log';
    file_put_contents(self::$log, '');
    $env = array_merge(getenv(), ['HB_GEO_LOG' => self::$log]);
    self::$server = proc_open(
      [PHP_BINARY, '-S', '127.0.0.1:' . self::PORT, __DIR__ . '/../../Support/HantuBanyu/server-geo-palsu.php'],
      [['pipe', 'r'], ['file', sys_get_temp_dir() . '/hb-geo-palsu-out.log', 'a'], ['file', sys_get_temp_dir() . '/hb-geo-palsu-out.log', 'a']],
      $pipes,
      null,
      $env,
      ['bypass_shell' => true]
    );

    for ($i = 0; $i < 50; $i++) {
      if (@fsockopen('127.0.0.1', self::PORT)) {
        return;
      }
      usleep(100000);
    }
    throw new \RuntimeException('Server geocoding palsu gagal dijalankan.');
  }

  public static function tearDownAfterClass(): void
  {
    if (self::$server) {
      proc_terminate(self::$server);
      proc_close(self::$server);
    }
    @unlink(self::$log);
    parent::tearDownAfterClass();
  }

  protected function setUp(): void
  {
    parent::setUp();
    file_put_contents(self::$log, '');
    config([
      'services.nominatim.base_url' => 'http://127.0.0.1:' . self::PORT,
      'services.overpass.url' => 'http://127.0.0.1:' . self::PORT . '/interpreter',
    ]);
    Storage::fake('local');
    Storage::fake('public');
  }

  private function panggilanEksternal(): array
  {
    return array_values(array_filter(explode("\n", (string) file_get_contents(self::$log))));
  }

  public static function titikProvider(): array
  {
    return [
      'ada-jalan' => ['-0.4600000'],
      'tanpa-jalan-radius-250' => ['-0.4700000'],
      'gang-radius-600' => ['-0.4800000'],
      'overpass-kosong' => ['-0.4900000'],
      'nominatim-galat' => ['-0.5000000'],
      'overpass-menolak-lalu-600' => ['-0.5100000'],
    ];
  }

  /** Setiap titik diminta dua kali (mis. pengguna klik ulang titik yang sama). */
  #[DataProvider('titikProvider')]
  public function test_reverse_geocode(string $lat): void
  {
    $nama = 'geocode-' . $this->dataName();
    $hasil = [];

    foreach ([1, 2] as $ke) {
      $res = $this->getJson('/api/hantu-banyu/reverse-geocode?lat=' . $lat . '&lon=117.1300000');
      $hasil[] = ['status' => $res->getStatusCode(), 'json' => $res->json()];
    }

    $this->assertSame($hasil[0], $hasil[1], 'Permintaan kedua harus menghasilkan respons yang sama.');
    $this->assertSnapshot($nama . '.json', json_encode($hasil[0], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $this->assertQueryTidakBertambah($nama . '-panggilan-eksternal', count($this->panggilanEksternal()));
    $this->assertSnapshotUrutan($nama, $this->panggilanEksternal());
  }

  public function test_reverse_geocode_tanpa_parameter(): void
  {
    $res = $this->getJson('/api/hantu-banyu/reverse-geocode?lat=-0.46');
    $this->assertSnapshot('geocode-tanpa-parameter.json', json_encode(['status' => $res->getStatusCode(), 'json' => $res->json()], JSON_PRETTY_PRINT));
    $this->assertSame([], $this->panggilanEksternal());
  }

  public static function simpanProvider(): array
  {
    return [
      'di-kelurahan' => ['-0.4600000'],
      'di-luar-kelurahan' => ['-0.4650000'],
      'geocoder-mati' => ['-0.5000000'],
      'hanya-kecamatan' => ['-0.5200000'],
    ];
  }

  /**
   * Kirim form pengaduan sebagai akun kelurahan. Tiap skenario dikirim dua
   * kali dengan koordinat yang sama (mis. mengirim ulang setelah ditolak).
   */
  #[DataProvider('simpanProvider')]
  public function test_simpan_pengaduan_web(string $lat): void
  {
    $this->sebagaiKelurahan();
    $nama = 'simpan-web-' . $this->dataName();
    $jejak = [];

    foreach ([1, 2] as $ke) {
      $res = $this->from(route('guest.hantu-banyu.pengaduan.create'))->post(route('guest.hantu-banyu.pengaduan.store'), [
        'nama_lengkap' => 'Warga Uji',
        'alamat' => 'RT 01 Air Putih',
        'nomor_telepon' => '081234567890',
        'kecamatan_id' => 1,
        'kelurahan_id' => 1,
        'nama_jalan' => 'Jalan Pahlawan',
        'latitude' => $lat,
        'longitude' => '117.1300000',
        'detail_lokasi' => 'Depan warung',
        'deskripsi_pengaduan' => 'Saluran mampet',
        'laporan__foto_input' => [UploadedFile::fake()->image('a.jpg', 40, 30)],
        'bordered-checkbox' => 'on',
      ]);

      $jejak[] = [
        'status' => $res->getStatusCode(),
        'redirect' => $res->headers->get('Location'),
        'errors' => session('errors')?->getBag('default')->toArray(),
        'success' => session('success'),
      ];
    }

    $baru = DB::table('hantu_banyu_laporan')->where('id', '>', 37)->orderBy('id')
      ->get(['kode', 'dibuat_oleh_tipe', 'kecamatan_id', 'kelurahan_id', 'latitude', 'longitude']);

    $this->assertSnapshot($nama . '.json', json_encode([
      'kiriman' => $jejak,
      'laporan_baru' => $baru,
      'berkas' => Storage::disk('local')->allFiles(),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $this->assertQueryTidakBertambah($nama . '-panggilan-eksternal', count($this->panggilanEksternal()));
  }

  #[DataProvider('simpanProvider')]
  public function test_simpan_pengaduan_api(string $lat): void
  {
    DB::table('hantu_banyu_api_keys')->insert(['key' => 'kunci-uji', 'name' => 'Uji', 'is_active' => 1]);
    $nama = 'simpan-api-' . $this->dataName();
    $jejak = [];

    foreach ([1, 2] as $ke) {
      $res = $this->withHeaders(['X-API-KEY' => 'kunci-uji', 'Accept' => 'application/json'])
        ->post('/api/hantu-banyu/laporan/upload', [
          'nama_lengkap' => 'Warga API',
          'alamat' => 'RT 02',
          'nomor_telepon' => '081234567891',
          'kelurahan_id' => 1,
          'nama_jalan' => 'Jalan Pahlawan',
          'latitude' => $lat,
          'longitude' => '117.1300000',
          'detail_lokasi' => 'Dekat sekolah',
          'deskripsi_pengaduan' => 'Air meluap',
          'foto' => [UploadedFile::fake()->image('b.jpg', 40, 30)],
        ]);
      $jejak[] = ['status' => $res->getStatusCode(), 'json' => $res->json()];
    }

    $this->assertSnapshot($nama . '.json', json_encode([
      'kiriman' => $jejak,
      'berkas' => Storage::disk('local')->allFiles(),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $this->assertQueryTidakBertambah($nama . '-panggilan-eksternal', count($this->panggilanEksternal()));
  }

  /**
   * Urutan panggilan eksternal pada permintaan pertama harus tetap (urutan
   * fallback Nominatim -> Overpass 250 -> 600 -> 1200 tidak boleh berubah).
   */
  private function assertSnapshotUrutan(string $nama, array $panggilan): void
  {
    $pertama = [];
    foreach ($panggilan as $p) {
      if ($pertama && str_starts_with($p, 'nominatim')) {
        break;
      }
      $pertama[] = $p;
    }
    $this->assertSnapshot($nama . '-urutan.txt', implode("\n", $pertama));
  }
}
