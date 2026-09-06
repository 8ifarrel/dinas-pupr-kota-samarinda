<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\SilaladGuestController;
use App\Models\SKM;
use Carbon\Carbon;

/**
 * SKM khusus layanan SILALAD.
 *
 * Bentuknya mengikuti SKM Hantu Banyu (lihat HantuBanyuSKMAdminController)
 * dan sumber datanya sama: tabel `skm` bersama, difilter berdasarkan
 * layanan_id. Bedanya cuma skala penilaian - SILALAD pakai bintang 1-5,
 * bukan 1-4.
 *
 * Id layanan diambil dari SilaladGuestController supaya nilainya tidak
 * ditulis ulang di dua tempat.
 */
class SilaladSKMAdminController extends Controller
{
  /** Skala penilaian tertinggi yang bisa diberikan pelanggan (bintang 1-5). */
  private const SKALA_MAKSIMUM = 5;

  private const LABEL_NILAI = [
    1 => 'Tidak Puas',
    2 => 'Kurang Puas',
    3 => 'Cukup Puas',
    4 => 'Puas',
    5 => 'Sangat Puas',
  ];

  public function index()
  {
    $layananId = (new SilaladGuestController)->layanan_id;

    $survei = SKM::query()
      ->where('layanan_id', $layananId)
      ->orderByDesc('created_at')
      ->get(['id', 'nilai', 'kritik', 'saran', 'layanan_id', 'created_at']);

    $dinilai = $survei->whereNotNull('nilai');
    $totalDinilai = $dinilai->count();

    return view('admin.pages.silalad.skm.index', [
      'total_responden' => $survei->count(),
      'total_dinilai' => $totalDinilai,
      'rata_rata' => $totalDinilai > 0 ? round($dinilai->avg('nilai'), 3) : 0.0,
      'skala_maksimum' => self::SKALA_MAKSIMUM,
      'distribusi' => $this->distribusi($dinilai),
      'tren' => $this->tren($layananId),
      'masukan' => $this->masukan($survei),
      'total_masukan' => $survei->filter(fn($s) => $s->kritik || $s->saran)->count(),
      'page_title' => 'Survei Kepuasan Masyarakat pada SILALAD',
      'page_description' => 'Penilaian pelanggan setelah mendaftar layanan SILALAD.',
    ]);
  }

  /** Sebaran jumlah responden pada tiap nilai 1-5. */
  private function distribusi($dinilai): array
  {
    $jumlahPerNilai = $dinilai->countBy('nilai');
    $total = $dinilai->count();

    $hasil = [];
    foreach (self::LABEL_NILAI as $nilai => $label) {
      $jumlah = (int) ($jumlahPerNilai[$nilai] ?? 0);

      $hasil[] = [
        'nilai' => $nilai,
        'label' => $label,
        'jumlah' => $jumlah,
        'persen' => $total > 0 ? round($jumlah / $total * 100, 1) : 0.0,
      ];
    }

    return $hasil;
  }

  /** Tren nilai rata-rata 12 bulan terakhir, termasuk bulan yang belum ada respondennya. */
  private function tren(int $layananId): array
  {
    $mulai = Carbon::now()->startOfMonth()->subMonths(11);

    $agregat = SKM::query()
      ->whereNotNull('nilai')
      ->where('layanan_id', $layananId)
      ->where('created_at', '>=', $mulai)
      ->selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as jumlah, AVG(nilai) as rata')
      ->groupBy('tahun', 'bulan')
      ->get()
      ->keyBy(fn($b) => $b->tahun . '-' . $b->bulan);

    $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    $hasil = [];
    for ($i = 0; $i < 12; $i++) {
      $titik = $mulai->copy()->addMonths($i);
      $baris = $agregat->get($titik->year . '-' . $titik->month);

      $hasil[] = [
        'label' => $bulanNama[$titik->month - 1] . ' ' . $titik->format('y'),
        'jumlah' => $baris ? (int) $baris->jumlah : 0,
        'rata_rata' => $baris ? round((float) $baris->rata, 2) : null,
      ];
    }

    return $hasil;
  }

  /**
   * Penilaian terbaru, termasuk responden yang hanya memberi bintang tanpa
   * menuliskan kritik/saran - keduanya tetap ditampilkan pada satu daftar.
   */
  private function masukan($survei): array
  {
    return $survei
      ->take(50)
      ->map(fn($s) => [
        'nilai' => $s->nilai,
        'label_nilai' => self::LABEL_NILAI[$s->nilai] ?? '-',
        'kritik' => $s->kritik,
        'saran' => $s->saran,
        'waktu' => $s->created_at,
      ])
      ->values()
      ->all();
  }
}
