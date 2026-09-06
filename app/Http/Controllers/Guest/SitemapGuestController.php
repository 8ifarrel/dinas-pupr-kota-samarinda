<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\AlbumKegiatan;
use App\Models\Berita;
use App\Models\PPIDPelaksanaKategori;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

/**
 * Peta situs untuk mesin pencari.
 *
 * Hanya memuat halaman yang boleh diindeks. Halaman yang sudah dilarang pada
 * robots.txt maupun yang memakai middleware BlockSearchEngines (e-panel, SKM,
 * agenda kegiatan) sengaja tidak dimasukkan, begitu pula halaman
 * yang menuntut login seperti Hantu Banyu.
 */
class SitemapGuestController extends Controller
{
  /** Peta situs jarang berubah, jadi cukup dirakit ulang secara berkala. */
  private const MASA_CACHE_JAM = 6;

  public function index()
  {
    $xml = Cache::remember('sitemap_xml', now()->addHours(self::MASA_CACHE_JAM), function () {
      return $this->rakit($this->kumpulkanUrl());
    });

    return Response::make($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
  }


  /**
   * robots.txt disajikan lewat route (bukan berkas statis di public/) supaya
   * alamat sitemap ikut menyesuaikan domain yang sedang dipakai - baik saat
   * pengembangan lokal maupun setelah dipasang di domain resmi.
   */
  public function robots()
  {
    $isi = implode(PHP_EOL, [
      "User-agent: *",
      "Disallow: /e-panel",
      "Disallow: /skm",
      "",
      "Sitemap: " . route("guest.sitemap"),
      "",
    ]);

    return Response::make($isi, 200, ["Content-Type" => "text/plain; charset=UTF-8"]);
  }

  /** @return array<int,array{loc:string,lastmod:?string,changefreq:string,priority:string}> */
  private function kumpulkanUrl(): array
  {
    $url = [];

    // Halaman tetap
    $halamanTetap = [
      ['guest.portal.index', 'daily', '1.0'],
      ['guest.beranda.index', 'daily', '0.9'],
      ['guest.berita.kategori.index', 'daily', '0.8'],
      ['guest.pengumuman.index', 'weekly', '0.8'],
      ['guest.album-kegiatan.index', 'weekly', '0.6'],
      ['guest.ppid-pelaksana.kategori.index', 'weekly', '0.7'],
      ['guest.profil.profil-kepala-dinas.index', 'monthly', '0.5'],
      ['guest.profil.struktur-organisasi.index', 'monthly', '0.5'],
      ['guest.profil.visi-dan-misi.index', 'yearly', '0.4'],
      ['guest.profil.tupoksi.index', 'yearly', '0.4'],
      ['guest.profil.sejarah-dinas-pupr-kota-samarinda.index', 'yearly', '0.4'],
      ['guest.kebijakan-privasi.index', 'yearly', '0.3'],
    ];

    foreach ($halamanTetap as [$nama, $frekuensi, $prioritas]) {
      if (!app('router')->has($nama)) {
        continue;
      }

      $url[] = [
        'loc' => route($nama),
        'lastmod' => null,
        'changefreq' => $frekuensi,
        'priority' => $prioritas,
      ];
    }

    // Berita: paling sering diperbarui, jadi diberi prioritas lebih tinggi.
    foreach (Berita::orderByDesc('created_at')->get(['slug_berita', 'updated_at']) as $berita) {
      $url[] = [
        'loc' => route('guest.berita.show', ['slug_berita' => $berita->slug_berita]),
        'lastmod' => optional($berita->updated_at)->toAtomString(),
        'changefreq' => 'monthly',
        'priority' => '0.7',
      ];
    }

    // Kategori berita dan halaman detail unit kerja memakai slug susunan organisasi yang sama.
    $unit = SusunanOrganisasi::where('is_subbagian', 0)
      ->where('kelompok_susunan_organisasi', '!=', 'Kepala Dinas')
      ->get(['slug_susunan_organisasi', 'updated_at']);

    foreach ($unit as $u) {
      $url[] = [
        'loc' => route('guest.berita.kategori.show', ['slug_kategori' => $u->slug_susunan_organisasi]),
        'lastmod' => optional($u->updated_at)->toAtomString(),
        'changefreq' => 'weekly',
        'priority' => '0.6',
      ];

      $url[] = [
        'loc' => route('guest.profil.struktur-organisasi.show', ['slug_susunan_organisasi' => $u->slug_susunan_organisasi]),
        'lastmod' => optional($u->updated_at)->toAtomString(),
        'changefreq' => 'monthly',
        'priority' => '0.5',
      ];
    }

    foreach (AlbumKegiatan::get(['slug', 'updated_at']) as $album) {
      $url[] = [
        'loc' => route('guest.album-kegiatan.show', ['slug' => $album->slug]),
        'lastmod' => optional($album->updated_at)->toAtomString(),
        'changefreq' => 'monthly',
        'priority' => '0.5',
      ];
    }

    foreach (PPIDPelaksanaKategori::get(['slug', 'updated_at']) as $kategori) {
      $url[] = [
        'loc' => route('guest.ppid-pelaksana.kategori.show', ['slug' => $kategori->slug]),
        'lastmod' => optional($kategori->updated_at)->toAtomString(),
        'changefreq' => 'weekly',
        'priority' => '0.6',
      ];
    }

    return $url;
  }

  /** @param  array<int,array<string,?string>>  $url */
  private function rakit(array $url): string
  {
    $baris = [];
    $baris[] = '<?xml version="1.0" encoding="UTF-8"?>';
    $baris[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($url as $u) {
      $baris[] = '  <url>';
      $baris[] = '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1) . '</loc>';

      if (!empty($u['lastmod'])) {
        $baris[] = '    <lastmod>' . $u['lastmod'] . '</lastmod>';
      }

      $baris[] = '    <changefreq>' . $u['changefreq'] . '</changefreq>';
      $baris[] = '    <priority>' . $u['priority'] . '</priority>';
      $baris[] = '  </url>';
    }

    $baris[] = '</urlset>';

    return implode(PHP_EOL, $baris);
  }
}
