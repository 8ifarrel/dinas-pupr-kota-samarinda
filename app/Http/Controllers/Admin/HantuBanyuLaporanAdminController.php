<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\HantuBanyuLaporan;
use App\Models\HantuBanyuLaporanTindakLanjut;
use App\Models\HantuBanyuLaporanTindakLanjutFoto;
use App\Models\User;
use App\Support\HantuBanyu\OtorisasiPengelola;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Browsershot\Browsershot;

class HantuBanyuLaporanAdminController extends Controller
{
  /** Instance dibuat sekali per siklus request, supaya query unit pemilik tidak dijalankan dua kali. */
  private ?OtorisasiPengelola $otorisasi = null;

  private function otorisasi(): OtorisasiPengelola
  {
    return $this->otorisasi ??= new OtorisasiPengelola();
  }

  /** Tahap penanganan, berurutan sesuai alur kerja (juga nilai enum di migration). */
  public const STATUS = [
    'pending',
    'diterima',
    'menunggu_survei',
    'sudah_disurvei',
    'menunggu_jadwal_pengerjaan',
    'sedang_dikerjakan',
    'selesai',
  ];

  public const JENIS = [
    'belum_diklasifikasikan',
    'darurat',
    'biasa',
    'rutin',
  ];

  public function index()
  {
    $laporan = HantuBanyuLaporan::with([
      'pelapor',
      'kecamatan',
      'kelurahan',
      'tindakLanjut',
    ])
      ->orderByDesc('created_at')
      ->get();

    $laporan->each(function ($l) {
      $l->status_terkini = $this->statusTerkini($l->tindakLanjut);
      $l->jenis_laporan = optional($l->tindakLanjut->first())->jenis ?? 'belum_diklasifikasikan';
    });

    // Opsi tahun untuk filter unduh PDF (tahun laporan + tahun berjalan).
    $tahunOpsi = HantuBanyuLaporan::selectRaw('YEAR(created_at) as y')
      ->distinct()
      ->pluck('y')
      ->push((int) now()->year)
      ->unique()
      ->sortDesc()
      ->values();

    return view('admin.pages.hantu-banyu.laporan.index', [
      'page_title' => 'Daftar Laporan Hantu Banyu',
      'page_description' => 'Kelola seluruh laporan pengaduan drainase dan irigasi: lihat detail dan perbarui tindak lanjutnya.',
      'laporan' => $laporan,
      'tahun_opsi' => $tahunOpsi,
      'boleh_kelola' => $this->otorisasi()->bolehKelola(),
    ]);
  }

  /**
   * Unduh rekap laporan sebagai satu berkas PDF (satu laporan per halaman A4).
   * Filter: semua / rentang bulan-tahun / satu tahun / satu bulan pada tahun tertentu.
   */
  public function unduhPdf(Request $request)
  {
    $data = $request->validate([
      'mode' => ['required', 'in:semua,rentang,tahun,bulan'],
      'dari_bulan' => ['nullable', 'integer', 'between:1,12'],
      'dari_tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'sampai_bulan' => ['nullable', 'integer', 'between:1,12'],
      'sampai_tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'bulan' => ['nullable', 'integer', 'between:1,12'],
      'bulan_tahun' => ['nullable', 'integer', 'between:2000,2100'],
    ]);

    $query = $this->queryLaporanLengkap();

    [$judulRentang, $namaBerkasRentang, $galat] = $this->filterPeriode($data, $query);

    if ($galat) {
      return back()->with('error', $galat);
    }

    $laporan = $query->get();

    if ($laporan->isEmpty()) {
      return back()->with('error', 'Tidak ada laporan pada rentang waktu yang dipilih.');
    }

    $laporan->each(function ($l) {
      $l->status_terkini = $this->statusTerkini($l->tindakLanjut);
      $l->jenis_laporan = optional($l->tindakLanjut->first())->jenis ?? 'belum_diklasifikasikan';
    });

    $html = view('admin.pages.hantu-banyu.laporan.pdf', [
      'laporan' => $laporan,
      'judul_rentang' => $judulRentang,
      'daftar_status' => self::STATUS,
      'dicetak_pada' => Carbon::now()->translatedFormat('d F Y H:i') . ' WITA',
    ])->render();

    return $this->unduhHtmlSebagaiPdf($html, '[Hantu Banyu] Rekap Laporan - ' . $namaBerkasRentang . '.pdf');
  }

  /**
   * Unduh rekap laporan sebagai berkas Excel (.xlsx), satu baris per laporan.
   *
   * Pilihan periodenya sama persis dengan unduhan PDF - keduanya memakai
   * filterPeriode() yang sama supaya isinya tidak pernah berbeda untuk
   * pilihan yang sama.
   */
  public function unduhExcel(Request $request)
  {
    $data = $request->validate([
      'mode' => ['required', 'in:semua,rentang,tahun,bulan'],
      'dari_bulan' => ['nullable', 'integer', 'between:1,12'],
      'dari_tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'sampai_bulan' => ['nullable', 'integer', 'between:1,12'],
      'sampai_tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'tahun' => ['nullable', 'integer', 'between:2000,2100'],
      'bulan' => ['nullable', 'integer', 'between:1,12'],
      'bulan_tahun' => ['nullable', 'integer', 'between:2000,2100'],
    ]);

    $query = $this->queryLaporanLengkap();

    [$judulRentang, $namaBerkasRentang, $galat] = $this->filterPeriode($data, $query);

    if ($galat) {
      return back()->with('error', $galat);
    }

    $laporan = $query->get();

    if ($laporan->isEmpty()) {
      return back()->with('error', 'Tidak ada laporan pada rentang waktu yang dipilih.');
    }

    $laporan->each(function ($l) {
      $l->status_terkini = $this->statusTerkini($l->tindakLanjut);
      $l->jenis_laporan = optional($l->tindakLanjut->first())->jenis ?? 'belum_diklasifikasikan';
    });

    return $this->kirimExcel($laporan, $judulRentang, '[Hantu Banyu] Rekap Laporan - ' . $namaBerkasRentang . '.xlsx');
  }

  /**
   * Susun berkas .xlsx dari koleksi laporan lalu kirim sebagai unduhan.
   *
   * Berkas ditulis ke aliran keluaran langsung (bukan berkas sementara di
   * disk) supaya tidak meninggalkan sampah kalau unduhannya dibatalkan.
   */
  private function kirimExcel($laporan, string $judulRentang, string $namaBerkas)
  {
    $statusLabel = [
      'pending' => 'Menunggu Verifikasi',
      'diterima' => 'Diterima',
      'menunggu_survei' => 'Menunggu Survei',
      'sudah_disurvei' => 'Sudah Disurvei',
      'menunggu_jadwal_pengerjaan' => 'Menunggu Jadwal Pengerjaan',
      'sedang_dikerjakan' => 'Sedang Dikerjakan',
      'selesai' => 'Selesai',
    ];
    $jenisLabel = [
      'belum_diklasifikasikan' => 'Belum Diklasifikasikan',
      'darurat' => 'Penanganan Darurat',
      'biasa' => 'Penanganan Biasa',
      'rutin' => 'Pemeliharaan Rutin',
    ];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Rekap Laporan');

    $judul = 'Rekap Laporan Hantu Banyu — ' . $judulRentang;
    $sheet->setCellValue('A1', $judul);
    $sheet->mergeCells('A1:M1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

    $sheet->setCellValue('A2', 'Dicetak pada ' . Carbon::now()->translatedFormat('d F Y H:i') . ' WITA');
    $sheet->mergeCells('A2:M2');
    $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10);

    $kepala = [
      'No. Laporan', 'Tanggal Masuk', 'Jam', 'Dibuat Oleh', 'Nama Pelapor', 'Nomor Telepon',
      'Kecamatan', 'Kelurahan', 'Nama Jalan', 'Detail Lokasi', 'Latitude', 'Longitude',
      'Status Terkini', 'Jenis', 'Deskripsi Pengaduan',
    ];

    $baris = 4;
    foreach ($kepala as $i => $judulKolom) {
      $sheet->setCellValue([$i + 1, $baris], $judulKolom);
    }
    $sheet->getStyle('A4:O4')->getFont()->setBold(true);
    $sheet->freezePane('A5');

    foreach ($laporan as $l) {
      $baris++;
      $status = $l->status_terkini;
      $jenis = $l->jenis_laporan;

      $nilai = [
        $l->id,
        Carbon::parse($l->created_at)->translatedFormat('d F Y'),
        Carbon::parse($l->created_at)->format('H:i'),
        $l->label_pelapor,
        optional($l->pelapor)->nama_lengkap ?? '-',
        optional($l->pelapor)->nomor_telepon ?? '-',
        optional($l->kecamatan)->nama ?? '-',
        optional($l->kelurahan)->nama ?? '-',
        $l->nama_jalan,
        $l->detail_lokasi,
        $l->latitude,
        $l->longitude,
        $statusLabel[$status] ?? '-',
        $jenisLabel[$jenis] ?? '-',
        $l->deskripsi_pengaduan,
      ];

      foreach ($nilai as $i => $isi) {
        // Nomor telepon (kolom ke-6) ditulis sebagai teks apa adanya supaya
        // angka 0 di depannya tidak dipangkas Excel.
        if ($i + 1 === 6) {
          $sheet->setCellValueExplicit([$i + 1, $baris], (string) $isi, DataType::TYPE_STRING);
          continue;
        }

        $sheet->setCellValue([$i + 1, $baris], $isi);
      }
    }

    foreach (range('A', 'O') as $kolom) {
      $sheet->getColumnDimension($kolom)->setAutoSize(true);
    }
    // Kolom teks panjang lebih enak dibaca dengan lebar tetap + bungkus baris.
    foreach (['J', 'O'] as $kolom) {
      $sheet->getColumnDimension($kolom)->setAutoSize(false);
      $sheet->getColumnDimension($kolom)->setWidth(45);
      $sheet->getStyle($kolom . '5:' . $kolom . $baris)->getAlignment()->setWrapText(true);
    }

    $writer = new Xlsx($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, $namaBerkas, [
      'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
  }

  /** Query laporan lengkap dengan seluruh relasi yang dibutuhkan rekap. */
  private function queryLaporanLengkap()
  {
    return HantuBanyuLaporan::with([
      'pelapor.kelurahanAsal',
      'kecamatan',
      'kelurahan',
      'foto',
      'tindakLanjut.foto',
    ])->orderBy('created_at', 'asc')->orderBy('id', 'asc');
  }

  /**
   * Terapkan pilihan periode (semua/rentang/tahun/bulan) pada query rekap.
   *
   * @param  array<string,mixed>  $data  hasil validasi permintaan
   * @return array{0:string,1:string,2:?string} [judul rentang, nama berkas, pesan galat]
   */
  private function filterPeriode(array $data, $query): array
  {
    $bulanNama = [
      1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
      7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    if ($data['mode'] === 'rentang') {
      $dari = $this->wajibTanggal($data['dari_bulan'] ?? null, $data['dari_tahun'] ?? null, 'awal');
      $sampai = $this->wajibTanggal($data['sampai_bulan'] ?? null, $data['sampai_tahun'] ?? null, 'akhir');
      if (!$dari || !$sampai) {
        return ['', '', 'Lengkapi bulan dan tahun untuk rentang yang dipilih.'];
      }
      if ($dari->gt($sampai)) {
        [$dari, $sampai] = [$sampai->copy()->startOfMonth(), $dari->copy()->endOfMonth()];
      }
      $query->whereBetween('created_at', [$dari, $sampai]);

      return [
        'Periode ' . $bulanNama[(int) $dari->month] . ' ' . $dari->year
          . ' - ' . $bulanNama[(int) $sampai->month] . ' ' . $sampai->year,
        $bulanNama[(int) $dari->month] . ' ' . $dari->year
          . ' sd ' . $bulanNama[(int) $sampai->month] . ' ' . $sampai->year,
        null,
      ];
    }

    if ($data['mode'] === 'tahun') {
      $tahun = $data['tahun'] ?? null;
      if (!$tahun) {
        return ['', '', 'Pilih tahun terlebih dahulu.'];
      }
      $query->whereYear('created_at', $tahun);

      return ['Tahun ' . $tahun, 'Tahun ' . $tahun, null];
    }

    if ($data['mode'] === 'bulan') {
      $bulan = $data['bulan'] ?? null;
      $tahun = $data['bulan_tahun'] ?? null;
      if (!$bulan || !$tahun) {
        return ['', '', 'Pilih bulan dan tahun terlebih dahulu.'];
      }
      $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);

      return [$bulanNama[(int) $bulan] . ' ' . $tahun, $bulanNama[(int) $bulan] . ' ' . $tahun, null];
    }

    return ['Semua Laporan', 'Semua', null];
  }

  /**
   * Unduh satu laporan spesifik sebagai PDF (memakai template rekap yang sama,
   * lengkap dengan riwayat tindak lanjut).
   */
  public function unduhPdfSatu($id)
  {
    $laporan = HantuBanyuLaporan::with([
      'pelapor.kelurahanAsal',
      'kecamatan',
      'kelurahan',
      'foto',
      'tindakLanjut.foto',
    ])->findOrFail($id);

    $laporan->status_terkini = $this->statusTerkini($laporan->tindakLanjut);
    $laporan->jenis_laporan = optional($laporan->tindakLanjut->first())->jenis ?? 'belum_diklasifikasikan';

    $html = view('admin.pages.hantu-banyu.laporan.pdf', [
      'laporan' => collect([$laporan]),
      'judul_rentang' => 'Laporan Nomor ' . $laporan->id,
      'daftar_status' => self::STATUS,
      'dicetak_pada' => Carbon::now()->translatedFormat('d F Y H:i') . ' WITA',
    ])->render();

    return $this->unduhHtmlSebagaiPdf($html, '[Hantu Banyu] Laporan Nomor ' . $laporan->id . '.pdf');
  }

  /** Render HTML menjadi PDF A4 lewat Browsershot lalu kirim sebagai unduhan. */
  private function unduhHtmlSebagaiPdf(string $html, string $filename)
  {
    try {
      $tempDir = storage_path('app/temp');
      if (!File::exists($tempDir)) {
        File::makeDirectory($tempDir, 0755, true);
      }

      $pdfPath = $tempDir . DIRECTORY_SEPARATOR . $filename;

      $browsershot = Browsershot::html($html);

      // Di Windows path Node/npm perlu ditunjuk lewat .env; di Linux dibiarkan
      // kosong agar Browsershot mendeteksinya sendiri dari PATH.
      if ($nodeBinary = config('services.browsershot.node_binary')) {
        $browsershot->setNodeBinary($nodeBinary);
      }
      if ($npmBinary = config('services.browsershot.npm_binary')) {
        $browsershot->setNpmBinary($npmBinary);
      }

      $browsershot
        ->waitUntilNetworkIdle()
        ->format('A4')
        ->margins(8, 8, 8, 8)
        ->showBackground(true)
        ->savePdf($pdfPath);

      return response()->download($pdfPath, $filename, [
        'Content-Type' => 'application/pdf',
      ])->deleteFileAfterSend(true);
    } catch (\Throwable $e) {
      Log::error('PDF Hantu Banyu gagal: ' . $e->getMessage());
      return back()->with('error', 'Gagal membuat PDF. ' . $e->getMessage());
    }
  }

  /** Bangun Carbon dari (bulan, tahun); $sisi = "awal" -> awal bulan, "akhir" -> akhir bulan. */
  private function wajibTanggal(?int $bulan, ?int $tahun, string $sisi): ?Carbon
  {
    if (!$bulan || !$tahun) {
      return null;
    }
    $c = Carbon::create($tahun, $bulan, 1, 0, 0, 0);
    return $sisi === 'akhir' ? $c->endOfMonth() : $c->startOfMonth();
  }

  public function edit($id)
  {
    $laporan = HantuBanyuLaporan::with([
      'pelapor.kelurahanAsal',
      'kecamatan',
      'kelurahan',
      'foto',
      'tindakLanjut.foto',
    ])->findOrFail($id);

    // Petakan setiap tahap ke barisnya (null bila belum diisi)
    $slot = [];
    foreach (self::STATUS as $s) {
      $slot[$s] = $laporan->tindakLanjut->firstWhere('status', $s);
    }

    return view('admin.pages.hantu-banyu.laporan.edit', [
      'page_title' => 'Laporan Nomor ' . $laporan->id,
      'page_description' => 'Rincian laporan dan linimasa tindak lanjut per tahap.',
      'laporan' => $laporan,
      'slot' => $slot,
      'daftar_status' => self::STATUS,
      'daftar_jenis' => self::JENIS,
      'status_terkini' => $this->statusTerkini($laporan->tindakLanjut),
      'jenis_laporan' => optional($laporan->tindakLanjut->first())->jenis ?? 'belum_diklasifikasikan',
      'editable' => $this->slotEditable($laporan->tindakLanjut),
      // Seluruh admin boleh membaca halaman ini; hanya unit pengelola
      // (dan super admin) yang boleh mengisi tindak lanjutnya.
      'boleh_kelola' => $this->otorisasi()->bolehKelola(),
      'nama_unit_pengelola' => $this->otorisasi()->namaUnitPemilik(),
    ]);
  }

  /**
   * Isi / perbarui satu tahap. Membuat baris bila belum ada, memperbarui bila
   * sudah ada. Perubahan "jenis penanganan" disinkronkan ke seluruh tahap.
   */
  public function simpanSlot(Request $request, $id, $status)
  {
    abort_unless(in_array($status, self::STATUS, true), 404);

    $laporan = HantuBanyuLaporan::with('tindakLanjut')->findOrFail($id);

    abort_unless(
      $this->slotEditable($laporan->tindakLanjut)[$status] ?? false,
      403,
      'Tahap ini belum bisa diisi. Selesaikan tahap sebelumnya terlebih dahulu.'
    );

    $validated = $request->validate([
      'jenis' => ['required', 'in:' . implode(',', self::JENIS)],
      'deskripsi' => ['required', 'string'],
      'hapus_foto' => ['nullable', 'array'],
      'hapus_foto.*' => ['integer'],
      'foto' => ['nullable', 'array', 'max:5'],
      'foto.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ], [
      'jenis.required' => 'Jenis penanganan wajib dipilih.',
      'jenis.in' => 'Jenis penanganan tidak valid.',
      'deskripsi.required' => 'Deskripsi tahap wajib diisi.',
      'foto.max' => 'Maksimal 5 foto per tahap.',
      'foto.*.image' => 'Berkas harus berupa gambar.',
      'foto.*.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
      'foto.*.max' => 'Ukuran tiap foto maksimal 2MB.',
    ]);

    $row = HantuBanyuLaporanTindakLanjut::firstOrNew([
      'laporan_id' => $laporan->id,
      'status' => $status,
    ]);
    $row->deskripsi = $validated['deskripsi'];
    $row->jenis = $validated['jenis'];
    $row->save();

    // Jenis penanganan berlaku untuk seluruh laporan -> sinkronkan ke semua tahap
    HantuBanyuLaporanTindakLanjut::where('laporan_id', $laporan->id)
      ->update(['jenis' => $validated['jenis']]);

    if (!empty($validated['hapus_foto'])) {
      $fotos = HantuBanyuLaporanTindakLanjutFoto::where('tindak_lanjut_id', $row->id)
        ->whereIn('id', $validated['hapus_foto'])
        ->get();
      foreach ($fotos as $f) {
        Storage::disk('public')->delete($f->foto);
        $f->forceDelete();
      }
    }

    $this->simpanFoto($request, $laporan->id, $row);

    $laporan->touch();

    return redirect()
      ->route('admin.hantu-banyu.laporan.edit', $laporan->id)
      ->with('success', 'Tahap berhasil disimpan.');
  }

  // ------------------------------------------------------------------

  /** Tahap terjauh (menurut urutan alur) yang sudah punya baris. */
  private function statusTerkini($tindakLanjut): ?string
  {
    $ada = $tindakLanjut->pluck('status')->all();
    foreach (array_reverse(self::STATUS) as $s) {
      if (in_array($s, $ada, true)) {
        return $s;
      }
    }
    return null;
  }

  /**
   * Tahap mana yang boleh diisi/diedit:
   *  - tahap yang sudah terisi  -> boleh diedit (koreksi)
   *  - satu tahap tepat setelah tahap terjauh -> boleh diisi (maju bertahap)
   *  - pengecualian: bila baru pada "menunggu verifikasi" saja, boleh langsung ke "selesai"
   *
   * @return array<string,bool>
   */
  private function slotEditable($tindakLanjut): array
  {
    $terisi = $tindakLanjut->pluck('status')->all();

    $furthest = -1;
    foreach (self::STATUS as $i => $s) {
      if (in_array($s, $terisi, true)) {
        $furthest = $i;
      }
    }
    $next = $furthest + 1;
    $furthestStatus = $furthest >= 0 ? self::STATUS[$furthest] : null;

    $map = [];
    foreach (self::STATUS as $i => $s) {
      $map[$s] = in_array($s, $terisi, true)
        || $i === $next
        || ($furthestStatus === 'pending' && $s === 'selesai');
    }
    return $map;
  }

  private function simpanFoto(Request $request, int $laporanId, HantuBanyuLaporanTindakLanjut $tindak): void
  {
    if (!$request->hasFile('foto')) {
      return;
    }

    $dir = "hantu-banyu/{$laporanId}/tindak_lanjut";
    foreach ($request->file('foto') as $file) {
      if (!$file || !$file->isValid()) {
        continue;
      }
      $ext = $file->getClientOriginalExtension();
      $namaFoto = "tl{$tindak->id}_" . now()->format('YmdHis') . '_' . uniqid() . ".{$ext}";
      $file->storeAs("public/{$dir}", $namaFoto);
      HantuBanyuLaporanTindakLanjutFoto::create([
        'tindak_lanjut_id' => $tindak->id,
        'foto' => "{$dir}/{$namaFoto}",
      ]);
    }
  }
}
