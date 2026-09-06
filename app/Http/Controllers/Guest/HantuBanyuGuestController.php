<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Admin\HantuBanyuLaporanAdminController;
use App\Http\Controllers\Controller;
use App\Models\HantuBanyuLaporan;
use App\Models\HantuBanyuLaporanTindakLanjut;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Statistik laporan Hantu Banyu untuk halaman publik.
 *
 * Setiap akun kelurahan hanya melihat statistik laporan di kelurahannya.
 * Seluruh perhitungannya ditulis di berkas ini supaya halaman ini berdiri
 * sendiri dan tidak bergantung pada berkas lain.
 */
class HantuBanyuGuestController extends Controller
{
  public string $page_context = 'Hantu Banyu';

  public function index()
  {
    $kelurahanId = optional(Auth::guard('kelurahan')->user())->kelurahan_id;

    return view('guest.pages.hantu-banyu.index', array_merge(
      $this->compute($kelurahanId),
      [
        'meta_description' => 'Laporkan masalah banjir dan kerusakan saluran drainase dan irigasi melalui layanan Hantu Banyu Dinas PUPR Kota Samarinda.',
        'page_title' => 'Hantu Banyu',
        'page_subtitle' => 'Layanan Umum',
        'page_context' => $this->page_context,
      ]
    ));
  }

  /**
   * @param  int|null  $kelurahanId  bila diisi, statistik hanya mencakup laporan pada kelurahan tsb.
   * @return array<string,mixed> variabel siap-pakai untuk view statistik
   */
  private function compute(?int $kelurahanId = null): array
  {
    $STATUS = HantuBanyuLaporanAdminController::STATUS;
    $JENIS = HantuBanyuLaporanAdminController::JENIS;
    $urutan = array_flip($STATUS);

    $laporans = HantuBanyuLaporan::with(['kecamatan', 'kelurahan'])
      ->when($kelurahanId, fn($q) => $q->where('kelurahan_id', $kelurahanId))
      ->get(['id', 'kecamatan_id', 'kelurahan_id', 'created_at']);
    $tlByLaporan = HantuBanyuLaporanTindakLanjut::query()
      ->when($kelurahanId, fn($q) => $q->whereIn('laporan_id', $laporans->pluck('id')->all()))
      ->get(['laporan_id', 'status', 'jenis', 'created_at'])
      ->groupBy('laporan_id');

    $rows = $laporans->map(function ($l) use ($tlByLaporan, $urutan) {
      $tl = $tlByLaporan->get($l->id, collect());
      $terkini = $tl->sortByDesc(fn($r) => $urutan[$r->status] ?? -1)->first();

      return (object) [
        'created_at' => $l->created_at,
        'kecamatan' => $l->kecamatan->nama ?? 'Tidak diketahui',
        'kelurahan' => $l->kelurahan->nama ?? 'Tidak diketahui',
        'status' => $terkini->status ?? 'pending',
        'jenis' => optional($tl->first())->jenis ?? 'belum_diklasifikasikan',
        'selesai_at' => optional($tl->firstWhere('status', 'selesai'))->created_at,
      ];
    })->toBase(); // hindari perilaku khusus-model saat koleksi kosong (mis. unique())

    // ---- KPI global ----
    $now = Carbon::now();
    $total = $rows->count();
    $selesai = $rows->whereNotNull('selesai_at');
    $total_selesai = $selesai->count();
    $belum_diproses = $rows->where('status', 'pending')->count();
    $total_berjalan = $total - $total_selesai - $belum_diproses;

    // ---- Agregat per (tahun, bulan) ----
    $byYM = [];
    foreach ($rows as $r) {
      $y = (int) $r->created_at->year;
      $m = (int) $r->created_at->month;
      if (!isset($byYM[$y][$m])) {
        $byYM[$y][$m] = [
          'masuk' => 0,
          'status' => array_fill_keys($STATUS, 0),
          'jenis' => array_fill_keys($JENIS, 0),
          'kecamatan' => [],
          'kelurahan' => [],
        ];
      }
      $byYM[$y][$m]['masuk']++;
      $byYM[$y][$m]['status'][$r->status]++;
      $byYM[$y][$m]['jenis'][$r->jenis]++;
      $byYM[$y][$m]['kecamatan'][$r->kecamatan] =
        ($byYM[$y][$m]['kecamatan'][$r->kecamatan] ?? 0) + 1;
      // Kelurahan dikelompokkan per kecamatan (untuk chart dengan dropdown kecamatan).
      $byYM[$y][$m]['kelurahan'][$r->kecamatan][$r->kelurahan] =
        ($byYM[$y][$m]['kelurahan'][$r->kecamatan][$r->kelurahan] ?? 0) + 1;
    }

    $years = $rows->map(fn($r) => (int) $r->created_at->year)
      ->push((int) $now->year)
      ->unique()
      ->sortDesc()
      ->values();

    $kecamatanList = $kelurahanId
      ? collect([optional(optional(Kelurahan::with('kecamatan')->find($kelurahanId))->kecamatan)->nama])
        ->filter()->values()
      : Kecamatan::orderBy('nama')->pluck('nama');

    // Daftar kelurahan per kecamatan (untuk dropdown + sumbu chart per-kelurahan).
    $kelurahanMap = Kelurahan::with('kecamatan')
      ->orderBy('nama')
      ->get(['id', 'nama', 'kecamatan_id'])
      ->groupBy(fn($k) => $k->kecamatan->nama ?? 'Tidak diketahui')
      ->map(fn($grup) => $grup->pluck('nama')->values())
      ->sortKeys();

    return [
      'total' => $total,
      'total_selesai' => $total_selesai,
      'total_berjalan' => $total_berjalan,
      'belum_diproses' => $belum_diproses,
      'by_ym' => $byYM,
      'years' => $years,
      'kecamatan_list' => $kecamatanList,
      'kelurahan_map' => $kelurahanMap,
      'now_year' => (int) $now->year,
      'now_month' => (int) $now->month,
      'now_quarter' => (int) ceil($now->month / 3),
    ];
  }
}
