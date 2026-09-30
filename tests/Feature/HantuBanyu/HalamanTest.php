<?php

namespace Tests\Feature\HantuBanyu;

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Rekaman HTML halaman Hantu Banyu yang menjadi target optimasi: isi,
 * urutan data, status code, dan jumlah query.
 */
class HalamanTest extends HantuBanyuTestCase
{
  public static function daftarPengaduanProvider(): array
  {
    return [
      'default' => ['admin', []],
      'halaman-2' => ['admin', ['page' => 2]],
      'halaman-4' => ['admin', ['page' => 4]],
      'terlama' => ['admin', ['sort' => 'oldest']],
      'az' => ['admin', ['sort' => 'az', 'page' => 2]],
      'cari' => ['admin', ['search_query' => 'juanda']],
      'cari-kode' => ['admin', ['search_query' => 'HB-2026-001']],
      'status' => ['admin', ['status_filter' => 'selesai']],
      'status-latest-id' => ['admin', ['status_filter' => 'sedang_dikerjakan']],
      'jenis' => ['admin', ['jenis_filter' => 'darurat']],
      'pelapor-admin' => ['admin', ['pelapor_filter' => 'admin']],
      'rentang' => ['admin', ['tanggal_dari' => '2026-03-01', 'tanggal_sampai' => '2026-06-30']],
      'rentang-terbalik' => ['admin', ['tanggal_dari' => '2026-06-30', 'tanggal_sampai' => '2026-03-01']],
      'tanggal-ngawur' => ['admin', ['tanggal_dari' => 'kemarin']],
      'kelurahan' => ['kelurahan', []],
      'kelurahan-status' => ['kelurahan', ['status_filter' => 'pending']],
    ];
  }

  #[DataProvider('daftarPengaduanProvider')]
  public function test_daftar_pengaduan_publik(string $akun, array $query): void
  {
    $akun === 'admin' ? $this->sebagaiAdmin() : $this->sebagaiKelurahan();
    $nama = 'daftar-pengaduan-' . $this->dataName();

    [$res, $jumlah] = $this->hitungQuery(fn() => $this->get(route('guest.hantu-banyu.pengaduan.index', $query)));

    $res->assertOk();
    $this->assertSnapshot($nama . '.html', self::normalisasiHtml($res->getContent()));
    $this->assertQueryTidakBertambah($nama, $jumlah);
  }

  public static function petaProvider(): array
  {
    return ['admin' => ['admin'], 'kelurahan' => ['kelurahan']];
  }

  /**
   * HTML peta dibandingkan terpisah: kerangka HTML (tanpa JSON laporan)
   * harus identik, dan JSON laporan dibandingkan hanya pada field yang
   * dibaca JavaScript peta (urutan baris ikut dibandingkan).
   */
  #[DataProvider('petaProvider')]
  public function test_peta_sebaran(string $akun): void
  {
    $akun === 'admin' ? $this->sebagaiAdmin() : $this->sebagaiKelurahan();
    $nama = 'peta-sebaran-' . $akun;

    [$res, $jumlah] = $this->hitungQuery(fn() => $this->get(route('guest.hantu-banyu.peta-sebaran.index')));
    $res->assertOk();
    $html = self::normalisasiHtml($res->getContent());

    $this->assertSame(1, preg_match('/const laporanData = (.*);\n/', $html, $m));
    $data = json_decode($m[1], true);
    $this->assertIsArray($data);

    $dipakaiJs = array_map(fn($l) => [
      'kode' => $l['kode'],
      'latitude' => $l['latitude'],
      'longitude' => $l['longitude'],
      'nama_jalan' => $l['nama_jalan'],
      'status_laporan' => $l['status_laporan'],
      'jenis_laporan' => $l['jenis_laporan'],
      'kelurahan.nama' => $l['kelurahan']['nama'] ?? null,
      'kecamatan.nama' => $l['kecamatan']['nama'] ?? null,
    ], $data);

    $this->assertSnapshot($nama . '.kerangka.html', str_replace($m[1], '__DATA__', $html));
    $this->assertSnapshot($nama . '.data.json', json_encode($dipakaiJs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $this->assertQueryTidakBertambah($nama, $jumlah);
  }

  public static function statistikProvider(): array
  {
    return [
      'publik-admin' => ['admin', 'guest.hantu-banyu.index'],
      'publik-kelurahan' => ['kelurahan', 'guest.hantu-banyu.index'],
      'epanel' => ['admin', 'admin.hantu-banyu.statistik-laporan.index'],
    ];
  }

  #[DataProvider('statistikProvider')]
  public function test_statistik(string $akun, string $route): void
  {
    $akun === 'admin' ? $this->sebagaiAdmin() : $this->sebagaiKelurahan();
    $nama = 'statistik-' . $this->dataName();

    [$res, $jumlah] = $this->hitungQuery(fn() => $this->get(route($route)));

    $res->assertOk();
    $this->assertSnapshot($nama . '.html', self::normalisasiHtml($res->getContent()));
    $this->assertQueryTidakBertambah($nama, $jumlah);
  }

  public static function epanelProvider(): array
  {
    return [
      'laporan-super-admin' => ['admin', 'admin.hantu-banyu.laporan.index'],
      'laporan-admin-biasa' => ['admin_biasa', 'admin.hantu-banyu.laporan.index'],
      'pemeriksaan-berkala' => ['admin', 'admin.hantu-banyu.pemeriksaan-berkala.index'],
    ];
  }

  #[DataProvider('epanelProvider')]
  public function test_halaman_epanel(string $akun, string $route): void
  {
    $akun === 'admin' ? $this->sebagaiAdmin() : $this->sebagaiAdminBiasa();
    $nama = 'epanel-' . $this->dataName();

    [$res, $jumlah] = $this->hitungQuery(fn() => $this->get(route($route)));

    $res->assertOk();
    $this->assertSnapshot($nama . '.html', self::normalisasiHtml($res->getContent()));
    $this->assertQueryTidakBertambah($nama, $jumlah);
  }
}
