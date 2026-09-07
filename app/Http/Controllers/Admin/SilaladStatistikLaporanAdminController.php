<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Silalad;
use App\Models\Kecamatan;
use Carbon\Carbon;

/**
 * Statistik pesanan SILALAD untuk E-Panel.
 *
 * Bentuknya mengikuti pola statistik laporan Hantu Banyu (lihat
 * HantuBanyuStatistikLaporanAdminController), tapi datanya disesuaikan
 * dengan skema SILALAD sendiri: SILALAD tidak mengenal "jenis pengaduan"
 * atau tindak lanjut bertahap seperti Hantu Banyu, jadi:
 * - Status pesanan dipakai langsung dari status_pengerjaan (4 nilai).
 * - "Jenis" memakai jenis_bangunan, dibatasi ke beberapa yang paling sering
 *   muncul supaya legenda chart tidak membludak (sisanya masuk "Lainnya").
 * - Sebaran wilayah 2 tingkat: Kabupaten/Kota (kabkota_id) lalu Kecamatan,
 *   menggantikan Kecamatan -> Kelurahan milik Hantu Banyu.
 *
 * Seluruh perhitungannya ditulis di berkas ini supaya halaman ini berdiri
 * sendiri dan tidak bergantung pada berkas lain.
 */
class SilaladStatistikLaporanAdminController extends Controller
{
  /** @deprecated Daftar status kini tunggal di Silalad::STATUS. */
  public const STATUS = Silalad::STATUS;

  /** Berapa jenis bangunan teratas yang ditampilkan sendiri-sendiri; sisanya digabung jadi "Lainnya". */
  private const MAKS_JENIS_BANGUNAN = 5;

  public function index()
  {
    return view('admin.pages.silalad.statistik-laporan.index', array_merge(
      $this->compute(),
      [
        'page_title' => 'Statistik Laporan SILALAD',
        'page_description' => 'Ringkasan kinerja penanganan pesanan layanan SILALAD.',
      ]
    ));
  }

  /** @return array<string,mixed> variabel siap-pakai untuk view statistik */
  private function compute(): array
  {
    $pesanan = Silalad::all(['id', 'status_pengerjaan', 'jenis_bangunan', 'kabkota_id', 'kecamatan_id', 'created_at']);

    $now = Carbon::now();
    $total = $pesanan->count();
    $perStatus = $pesanan->countBy('status_pengerjaan');
    $totalSelesai = (int) ($perStatus[Silalad::SELESAI] ?? 0);
    // "Sedang berjalan" mencakup dua tahap: sudah dijadwalkan tapi armada
    // belum turun, dan armada yang sedang menyedot di lokasi. Keduanya sama-
    // sama pekerjaan yang belum tuntas, jadi dijumlahkan jadi satu KPI.
    $totalBerjalan = (int) ($perStatus[Silalad::DIJADWALKAN] ?? 0)
      + (int) ($perStatus[Silalad::DIKERJAKAN] ?? 0);
    $belumDiproses = (int) ($perStatus[Silalad::MENUNGGU] ?? 0);
    $dibatalkan = (int) ($perStatus[Silalad::DIBATALKAN] ?? 0);

    // Jenis bangunan paling sering muncul, sisanya dikelompokkan "Lainnya".
    $jenisTerlaris = $pesanan->countBy('jenis_bangunan')
      ->sortDesc()
      ->take(self::MAKS_JENIS_BANGUNAN)
      ->keys()
      ->all();

    // Cache nama kecamatan (id numerik Samarinda -> nama), supaya tidak
    // query berulang untuk tiap baris.
    $kecamatanNama = Kecamatan::pluck('nama', 'id');
    $resolveKecamatan = fn($id) => $kecamatanNama[$id] ?? (string) $id;

    // ---- Agregat per (tahun, bulan) ----
    $byYM = [];
    foreach ($pesanan as $p) {
      $y = (int) $p->created_at->year;
      $m = (int) $p->created_at->month;
      if (!isset($byYM[$y][$m])) {
        $byYM[$y][$m] = [
          'masuk' => 0,
          'status' => array_fill_keys(self::STATUS, 0),
          'jenis_bangunan' => array_fill_keys(array_merge($jenisTerlaris, ['Lainnya']), 0),
          'kabkota' => [],
          'kecamatan' => [],
        ];
      }

      $jenis = in_array($p->jenis_bangunan, $jenisTerlaris, true) ? $p->jenis_bangunan : 'Lainnya';
      $kabkota = $p->kabkota_id ?: 'Tidak diketahui';
      $namaKecamatan = $resolveKecamatan($p->kecamatan_id);

      $byYM[$y][$m]['masuk']++;
      $byYM[$y][$m]['status'][$p->status_pengerjaan] = ($byYM[$y][$m]['status'][$p->status_pengerjaan] ?? 0) + 1;
      $byYM[$y][$m]['jenis_bangunan'][$jenis]++;
      $byYM[$y][$m]['kabkota'][$kabkota] = ($byYM[$y][$m]['kabkota'][$kabkota] ?? 0) + 1;
      // Kecamatan dikelompokkan per kabupaten/kota (untuk chart dengan dropdown kabkota).
      $byYM[$y][$m]['kecamatan'][$kabkota][$namaKecamatan] =
        ($byYM[$y][$m]['kecamatan'][$kabkota][$namaKecamatan] ?? 0) + 1;
    }

    $years = $pesanan->map(fn($p) => (int) $p->created_at->year)
      ->push((int) $now->year)
      ->unique()
      ->sortDesc()
      ->values();

    $kabkotaList = $pesanan->pluck('kabkota_id')->filter()->unique()->sort()->values();

    // Daftar kecamatan per kabupaten/kota (untuk dropdown + sumbu chart per-kecamatan).
    $kecamatanMap = $pesanan
      ->groupBy(fn($p) => $p->kabkota_id ?: 'Tidak diketahui')
      ->map(fn($grup) => $grup->map(fn($p) => $resolveKecamatan($p->kecamatan_id))->unique()->sort()->values());

    return [
      'total' => $total,
      'total_selesai' => $totalSelesai,
      'total_berjalan' => $totalBerjalan,
      'belum_diproses' => $belumDiproses,
      'dibatalkan' => $dibatalkan,
      'jenis_bangunan_list' => array_merge($jenisTerlaris, ['Lainnya']),
      'by_ym' => $byYM,
      'years' => $years,
      'kabkota_list' => $kabkotaList,
      'kecamatan_map' => $kecamatanMap,
      'now_year' => (int) $now->year,
      'now_month' => (int) $now->month,
      'now_quarter' => (int) ceil($now->month / 3),
    ];
  }
}
