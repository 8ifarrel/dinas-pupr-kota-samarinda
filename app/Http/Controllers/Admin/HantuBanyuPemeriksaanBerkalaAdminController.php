<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HantuBanyuPemeriksaanBerkala;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Support\HantuBanyu\OtorisasiPengelola;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Browsershot\Browsershot;

class HantuBanyuPemeriksaanBerkalaAdminController extends Controller
{
  public const STATUS_ALIRAN = [
    'lancar',
    'kurang_lancar',
    'tersumbat_sebagian',
    'macet_total',
  ];

  public const STATUS_ALIRAN_LABEL = [
    'lancar' => 'Lancar',
    'kurang_lancar' => 'Kurang Lancar',
    'tersumbat_sebagian' => 'Tersumbat Sebagian',
    'macet_total' => 'Macet Total',
  ];

  public const RUAS_SALURAN = [
    'primer',
    'sekunder',
    'tersier',
  ];

  public const RUAS_SALURAN_LABEL = [
    'primer' => 'Saluran Primer',
    'sekunder' => 'Saluran Sekunder',
    'tersier' => 'Saluran Tersier',
  ];

  public function index()
  {
    $pemeriksaan = HantuBanyuPemeriksaanBerkala::with(['kecamatan', 'kelurahan'])
      ->orderByDesc('tanggal_pemeriksaan')
      ->orderByDesc('id')
      ->get();

    // Opsi tahun untuk filter unduh PDF/Excel (tahun pemeriksaan + tahun berjalan).
    $tahunOpsi = HantuBanyuPemeriksaanBerkala::selectRaw('YEAR(tanggal_pemeriksaan) as y')
      ->distinct()
      ->pluck('y')
      ->push((int) now()->year)
      ->unique()
      ->sortDesc()
      ->values();

    return view('admin.pages.hantu-banyu.pemeriksaan-berkala.index', [
      'page_title' => 'Pemeriksaan Berkala Saluran',
      'page_description' => 'Catat hasil patroli/pemeriksaan rutin kondisi ruas saluran drainase dan irigasi.',
      'pemeriksaan' => $pemeriksaan,
      'status_aliran_label' => self::STATUS_ALIRAN_LABEL,
      'ruas_saluran_label' => self::RUAS_SALURAN_LABEL,
      'kategori_sedimentasi_label' => HantuBanyuPemeriksaanBerkala::KATEGORI_SEDIMENTASI_LABEL,
      'tahun_opsi' => $tahunOpsi,
      'boleh_kelola' => (new OtorisasiPengelola())->bolehKelola(),
    ]);
  }

  public function create()
  {
    return view('admin.pages.hantu-banyu.pemeriksaan-berkala.create', [
      'page_title' => 'Tambah Pemeriksaan Berkala',
      'page_description' => 'Catat hasil pemeriksaan lapangan pada satu ruas saluran.',
      'pemeriksaan' => new HantuBanyuPemeriksaanBerkala(),
      'daftar_kecamatan' => Kecamatan::orderBy('nama')->get(['id', 'nama']),
      'daftar_kelurahan' => Kelurahan::orderBy('nama')->get(['id', 'nama', 'kecamatan_id']),
      'status_aliran_label' => self::STATUS_ALIRAN_LABEL,
      'ruas_saluran_label' => self::RUAS_SALURAN_LABEL,
    ]);
  }

  public function store(Request $request)
  {
    HantuBanyuPemeriksaanBerkala::create($this->validasi($request));

    return redirect()
      ->route('admin.hantu-banyu.pemeriksaan-berkala.index')
      ->with('success', 'Pemeriksaan berkala berhasil dicatat.');
  }

  public function edit(HantuBanyuPemeriksaanBerkala $pemeriksaan_berkala)
  {
    return view('admin.pages.hantu-banyu.pemeriksaan-berkala.edit', [
      'page_title' => 'Edit Pemeriksaan Berkala',
      'page_description' => 'Perbarui catatan hasil pemeriksaan ruas saluran ini.',
      'pemeriksaan' => $pemeriksaan_berkala,
      'daftar_kecamatan' => Kecamatan::orderBy('nama')->get(['id', 'nama']),
      'daftar_kelurahan' => Kelurahan::orderBy('nama')->get(['id', 'nama', 'kecamatan_id']),
      'status_aliran_label' => self::STATUS_ALIRAN_LABEL,
      'ruas_saluran_label' => self::RUAS_SALURAN_LABEL,
    ]);
  }

  public function update(Request $request, HantuBanyuPemeriksaanBerkala $pemeriksaan_berkala)
  {
    $pemeriksaan_berkala->update($this->validasi($request));

    return redirect()
      ->route('admin.hantu-banyu.pemeriksaan-berkala.index')
      ->with('success', 'Pemeriksaan berkala berhasil diperbarui.');
  }

  public function destroy(HantuBanyuPemeriksaanBerkala $pemeriksaan_berkala)
  {
    $pemeriksaan_berkala->delete();

    return redirect()
      ->route('admin.hantu-banyu.pemeriksaan-berkala.index')
      ->with('success', 'Catatan pemeriksaan berkala berhasil dihapus.');
  }

  /**
   * Unduh rekap sebagai PDF: semua data, atau dibatasi rentang tanggal
   * pemeriksaan.
   */
  public function unduhPdf(Request $request)
  {
    [$query, $judulRentang, $namaBerkasRentang, $galat] = $this->queryPeriode($request);

    if ($galat) {
      return back()->with('error', $galat);
    }

    $pemeriksaan = $query->get();

    if ($pemeriksaan->isEmpty()) {
      return back()->with('error', 'Tidak ada catatan pemeriksaan pada rentang waktu yang dipilih.');
    }

    $html = view('admin.pages.hantu-banyu.pemeriksaan-berkala.pdf', [
      'pemeriksaan' => $pemeriksaan,
      'judul_rentang' => $judulRentang,
      'status_aliran_label' => self::STATUS_ALIRAN_LABEL,
      'ruas_saluran_label' => self::RUAS_SALURAN_LABEL,
      'kategori_sedimentasi_label' => HantuBanyuPemeriksaanBerkala::KATEGORI_SEDIMENTASI_LABEL,
      'dicetak_pada' => Carbon::now()->translatedFormat('d F Y H:i') . ' WITA',
    ])->render();

    return $this->unduhHtmlSebagaiPdf($html, '[Hantu Banyu] Pemeriksaan Berkala - ' . $namaBerkasRentang . '.pdf');
  }

  public function unduhExcel(Request $request)
  {
    [$query, $judulRentang, $namaBerkasRentang, $galat] = $this->queryPeriode($request);

    if ($galat) {
      return back()->with('error', $galat);
    }

    $pemeriksaan = $query->get();

    if ($pemeriksaan->isEmpty()) {
      return back()->with('error', 'Tidak ada catatan pemeriksaan pada rentang waktu yang dipilih.');
    }

    return $this->kirimExcel($pemeriksaan, $judulRentang, '[Hantu Banyu] Pemeriksaan Berkala - ' . $namaBerkasRentang . '.xlsx');
  }

  // ------------------------------------------------------------------

  private function validasi(Request $request): array
  {
    return $request->validate([
      'tanggal_pemeriksaan' => ['required', 'date'],
      'kecamatan_id' => ['required', 'integer', 'exists:kecamatan,id'],
      'kelurahan_id' => ['required', 'integer', 'exists:kelurahan,id'],
      'nama_jalan' => ['required', 'string', 'max:150'],
      'nama_ruas_saluran' => ['required', 'in:' . implode(',', self::RUAS_SALURAN)],
      'dimensi_lebar_m' => ['required', 'numeric', 'min:0.01', 'max:999.99'],
      'dimensi_tinggi_m' => ['required', 'numeric', 'min:0.01', 'max:999.99'],
      'kondisi_fisik_struktur' => ['required', 'string'],
      'tingkat_sedimentasi_sampah_cm' => ['required', 'numeric', 'min:0', 'max:999.9'],
      'status_aliran_air' => ['required', 'in:' . implode(',', self::STATUS_ALIRAN)],
      'tindakan_pemeliharaan' => ['required', 'string'],
      'hambatan_kendala' => ['required', 'string'],
      'rekomendasi_tindak_lanjut' => ['required', 'string'],
    ], [], [
      'tanggal_pemeriksaan' => 'tanggal pemeriksaan',
      'kecamatan_id' => 'kecamatan',
      'kelurahan_id' => 'kelurahan',
      'nama_jalan' => 'nama jalan',
      'nama_ruas_saluran' => 'nama ruas saluran',
      'dimensi_lebar_m' => 'lebar',
      'dimensi_tinggi_m' => 'tinggi',
      'kondisi_fisik_struktur' => 'kondisi fisik struktur',
      'tingkat_sedimentasi_sampah_cm' => 'tingkat sedimentasi & sampah',
      'status_aliran_air' => 'status aliran air',
      'tindakan_pemeliharaan' => 'tindakan pemeliharaan yang dilakukan',
    ]);
  }

  /**
   * Query pemeriksaan berkala terurut, dibatasi periode bila diminta.
   * Pilihan periodenya disamakan dengan filter unduh daftar laporan
   * (HantuBanyuLaporanAdminController::filterPeriode()): semua / hari ini /
   * rentang tanggal-bulan-tahun / satu tahun / satu bulan pada tahun tertentu.
   *
   * @return array{0:mixed,1:string,2:string,3:?string} [query, judul rentang, nama berkas, pesan galat]
   */
  private function queryPeriode(Request $request): array
  {
    $data = $request->validate([
      'mode' => ['required', 'in:semua,hari_ini,rentang,tahun,bulan'],
      'dari_tanggal' => ['nullable', 'date'],
      'sampai_tanggal' => ['nullable', 'date'],
      'tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'periode_bulan' => ['nullable', 'date_format:Y-m'],
    ]);

    $bulanNama = [
      1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
      7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $query = HantuBanyuPemeriksaanBerkala::with(['kecamatan', 'kelurahan'])
      ->orderBy('tanggal_pemeriksaan')
      ->orderBy('id');

    if ($data['mode'] === 'hari_ini') {
      $hariIni = Carbon::today();
      $query->whereDate('tanggal_pemeriksaan', $hariIni);

      return [$query, 'Hari Ini (' . $hariIni->translatedFormat('d F Y') . ')', 'Hari Ini ' . $hariIni->format('Y-m-d'), null];
    }

    if ($data['mode'] === 'rentang') {
      $dari = $data['dari_tanggal'] ?? null;
      $sampai = $data['sampai_tanggal'] ?? null;

      if (!$dari || !$sampai) {
        return [$query, '', '', 'Lengkapi tanggal awal dan akhir untuk rentang yang dipilih.'];
      }

      $dari = Carbon::parse($dari)->startOfDay();
      $sampai = Carbon::parse($sampai)->endOfDay();
      if ($dari->gt($sampai)) {
        [$dari, $sampai] = [$sampai->copy()->startOfDay(), $dari->copy()->endOfDay()];
      }

      $query->whereBetween('tanggal_pemeriksaan', [$dari, $sampai]);

      $judul = 'Periode ' . $dari->translatedFormat('d F Y') . ' - ' . $sampai->translatedFormat('d F Y');
      $namaBerkas = $dari->format('Y-m-d') . '_sd_' . $sampai->format('Y-m-d');

      return [$query, $judul, $namaBerkas, null];
    }

    if ($data['mode'] === 'tahun') {
      $tahun = $data['tahun'] ?? null;
      if (!$tahun) {
        return [$query, '', '', 'Pilih tahun terlebih dahulu.'];
      }
      $query->whereYear('tanggal_pemeriksaan', $tahun);

      return [$query, 'Tahun ' . $tahun, 'Tahun ' . $tahun, null];
    }

    if ($data['mode'] === 'bulan') {
      $periodeBulan = $data['periode_bulan'] ?? null;
      if (!$periodeBulan) {
        return [$query, '', '', 'Pilih bulan terlebih dahulu.'];
      }
      [$tahun, $bulan] = explode('-', $periodeBulan);
      $query->whereYear('tanggal_pemeriksaan', $tahun)->whereMonth('tanggal_pemeriksaan', $bulan);

      return [$query, $bulanNama[(int) $bulan] . ' ' . $tahun, $bulanNama[(int) $bulan] . ' ' . $tahun, null];
    }

    return [$query, 'Semua Pemeriksaan', 'Semua', null];
  }

  /** "20% (Sedang)", atau "-" bila persentasenya belum bisa dihitung (kolom cm/tinggi kosong). */
  private function labelPersenSedimentasi(HantuBanyuPemeriksaanBerkala $p): string
  {
    if ($p->persen_sedimentasi === null) {
      return '-';
    }

    $kategoriLabel = HantuBanyuPemeriksaanBerkala::KATEGORI_SEDIMENTASI_LABEL[$p->kategori_sedimentasi] ?? '-';

    return $p->persen_sedimentasi . '% (' . $kategoriLabel . ')';
  }

  private function kirimExcel($pemeriksaan, string $judulRentang, string $namaBerkas)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Pemeriksaan Berkala');

    $sheet->setCellValue('A1', 'Pemeriksaan Berkala Saluran Hantu Banyu — ' . $judulRentang);
    $sheet->mergeCells('A1:N1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

    $sheet->setCellValue('A2', 'Dicetak pada ' . Carbon::now()->translatedFormat('d F Y H:i') . ' WITA');
    $sheet->mergeCells('A2:N2');
    $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10);

    $kepala = [
      'No', 'Tanggal Pemeriksaan', 'Kecamatan', 'Kelurahan', 'Nama Jalan', 'Nama Ruas Saluran',
      'Dimensi Eksisting (L x T)', 'Kondisi Fisik Struktur', 'Sedimentasi & Sampah (cm)',
      'Sedimentasi (%) / Kategori', 'Status Aliran Air', 'Tindakan Pemeliharaan yang Dilakukan',
      'Hambatan / Kendala Lapangan', 'Rekomendasi / Tindak Lanjut',
    ];

    $baris = 4;
    foreach ($kepala as $i => $judulKolom) {
      $sheet->setCellValue([$i + 1, $baris], $judulKolom);
    }
    $sheet->getStyle('A4:N4')->getFont()->setBold(true);
    $sheet->freezePane('A5');

    foreach ($pemeriksaan as $i => $p) {
      $baris++;
      $dimensi = ($p->dimensi_lebar_m !== null && $p->dimensi_tinggi_m !== null)
        ? number_format((float) $p->dimensi_lebar_m, 2) . ' m x ' . number_format((float) $p->dimensi_tinggi_m, 2) . ' m'
        : '-';

      $nilai = [
        $i + 1,
        $p->tanggal_pemeriksaan->translatedFormat('d F Y'),
        optional($p->kecamatan)->nama ?? '-',
        optional($p->kelurahan)->nama ?? '-',
        $p->nama_jalan,
        self::RUAS_SALURAN_LABEL[$p->nama_ruas_saluran] ?? $p->nama_ruas_saluran,
        $dimensi,
        $p->kondisi_fisik_struktur,
        $p->tingkat_sedimentasi_sampah_cm !== null ? $p->tingkat_sedimentasi_sampah_cm . ' cm' : '-',
        $this->labelPersenSedimentasi($p),
        self::STATUS_ALIRAN_LABEL[$p->status_aliran_air] ?? '-',
        $p->tindakan_pemeliharaan,
        $p->hambatan_kendala ?: '-',
        $p->rekomendasi_tindak_lanjut ?: '-',
      ];

      foreach ($nilai as $i2 => $isi) {
        $sheet->setCellValue([$i2 + 1, $baris], $isi);
      }
    }

    foreach (range('A', 'N') as $kolom) {
      $sheet->getColumnDimension($kolom)->setAutoSize(true);
    }
    foreach (['H', 'L', 'M', 'N'] as $kolom) {
      $sheet->getColumnDimension($kolom)->setAutoSize(false);
      $sheet->getColumnDimension($kolom)->setWidth(40);
      $sheet->getStyle($kolom . '5:' . $kolom . $baris)->getAlignment()->setWrapText(true);
    }

    $writer = new Xlsx($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, $namaBerkas, [
      'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
  }

  private function unduhHtmlSebagaiPdf(string $html, string $filename)
  {
    try {
      $tempDir = storage_path('app/temp');
      if (!File::exists($tempDir)) {
        File::makeDirectory($tempDir, 0755, true);
      }

      $pdfPath = $tempDir . DIRECTORY_SEPARATOR . $filename;

      $browsershot = Browsershot::html($html);

      if ($nodeBinary = config('services.browsershot.node_binary')) {
        $browsershot->setNodeBinary($nodeBinary);
      }
      if ($npmBinary = config('services.browsershot.npm_binary')) {
        $browsershot->setNpmBinary($npmBinary);
      }

      $browsershot
        // Batas bawaan Browsershot (60 detik proses, 30 detik protokol CDP)
        // sering kurang untuk rekap "Semua" yang berisi banyak catatan -
        // rentan gagal acak dengan "Page.printToPDF timed out" saat render
        // kebetulan lambat (beban CPU, dsb). Dinaikkan supaya konsisten.
        ->timeout(180)
        ->protocolTimeout(180)
        ->waitUntilNetworkIdle()
        ->format('A4')
        ->landscape()
        ->margins(8, 8, 8, 8)
        ->showBackground(true)
        ->savePdf($pdfPath);

      return response()->download($pdfPath, $filename, [
        'Content-Type' => 'application/pdf',
      ])->deleteFileAfterSend(true);
    } catch (\Throwable $e) {
      Log::error('PDF Pemeriksaan Berkala Hantu Banyu gagal: ' . $e->getMessage());
      return back()->with('error', 'Gagal membuat PDF. ' . $e->getMessage());
    }
  }
}
