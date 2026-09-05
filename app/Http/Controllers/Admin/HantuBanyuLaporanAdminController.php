<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\DrainaseIrigasiLaporan;
use App\Models\DrainaseIrigasiLaporanTindakLanjut;
use App\Models\DrainaseIrigasiLaporanTindakLanjutFoto;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class HantuBanyuLaporanAdminController extends Controller
{
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
        $laporan = DrainaseIrigasiLaporan::with([
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
        $tahunOpsi = DrainaseIrigasiLaporan::selectRaw('YEAR(created_at) as y')
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

        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $query = DrainaseIrigasiLaporan::with([
            'pelapor.kelurahanAsal',
            'kecamatan',
            'kelurahan',
            'foto',
            'tindakLanjut.foto',
        ])->orderBy('created_at', 'asc')->orderBy('id', 'asc');

        $judulRentang = 'Semua Laporan';
        $namaBerkasRentang = 'Semua';

        if ($data['mode'] === 'rentang') {
            $dari = $this->wajibTanggal($data['dari_bulan'] ?? null, $data['dari_tahun'] ?? null, 'awal');
            $sampai = $this->wajibTanggal($data['sampai_bulan'] ?? null, $data['sampai_tahun'] ?? null, 'akhir');
            if (!$dari || !$sampai) {
                return back()->with('error', 'Lengkapi bulan dan tahun untuk rentang yang dipilih.');
            }
            if ($dari->gt($sampai)) {
                [$dari, $sampai] = [$sampai->copy()->startOfMonth(), $dari->copy()->endOfMonth()];
            }
            $query->whereBetween('created_at', [$dari, $sampai]);
            $judulRentang = 'Periode ' . $bulanNama[(int) $dari->month] . ' ' . $dari->year
                . ' – ' . $bulanNama[(int) $sampai->month] . ' ' . $sampai->year;
            $namaBerkasRentang = $bulanNama[(int) $dari->month] . ' ' . $dari->year
                . ' sd ' . $bulanNama[(int) $sampai->month] . ' ' . $sampai->year;
        } elseif ($data['mode'] === 'tahun') {
            $tahun = $data['tahun'] ?? null;
            if (!$tahun) {
                return back()->with('error', 'Pilih tahun terlebih dahulu.');
            }
            $query->whereYear('created_at', $tahun);
            $judulRentang = 'Tahun ' . $tahun;
            $namaBerkasRentang = 'Tahun ' . $tahun;
        } elseif ($data['mode'] === 'bulan') {
            $bulan = $data['bulan'] ?? null;
            $tahun = $data['bulan_tahun'] ?? null;
            if (!$bulan || !$tahun) {
                return back()->with('error', 'Pilih bulan dan tahun terlebih dahulu.');
            }
            $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
            $judulRentang = $bulanNama[(int) $bulan] . ' ' . $tahun;
            $namaBerkasRentang = $bulanNama[(int) $bulan] . ' ' . $tahun;
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
     * Unduh satu laporan spesifik sebagai PDF (memakai template rekap yang sama,
     * lengkap dengan riwayat tindak lanjut).
     */
    public function unduhPdfSatu($id)
    {
        $laporan = DrainaseIrigasiLaporan::with([
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

            // Path khusus Windows (konsisten dengan generator PDF sisi pelapor).
            $nodeBinary = 'C:\Program Files\nodejs\node.exe';
            $npmBinary = 'C:\Program Files\nodejs\npm.cmd';

            $pdfPath = $tempDir . '\\' . $filename;

            Browsershot::html($html)
                ->setNodeBinary($nodeBinary)
                ->setNpmBinary($npmBinary)
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

    public function detail($id)
    {
        $laporan = DrainaseIrigasiLaporan::with([
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

        return view('admin.pages.hantu-banyu.laporan.detail', [
            'page_title' => 'Laporan Nomor ' . $laporan->id,
            'page_description' => 'Rincian laporan dan linimasa tindak lanjut per tahap.',
            'laporan' => $laporan,
            'slot' => $slot,
            'daftar_status' => self::STATUS,
            'daftar_jenis' => self::JENIS,
            'status_terkini' => $this->statusTerkini($laporan->tindakLanjut),
            'jenis_laporan' => optional($laporan->tindakLanjut->first())->jenis ?? 'belum_diklasifikasikan',
            'editable' => $this->slotEditable($laporan->tindakLanjut),
        ]);
    }

    /**
     * Isi / perbarui satu tahap. Membuat baris bila belum ada, memperbarui bila
     * sudah ada. Perubahan "jenis penanganan" disinkronkan ke seluruh tahap.
     */
    public function simpanSlot(Request $request, $id, $status)
    {
        abort_unless(in_array($status, self::STATUS, true), 404);

        $laporan = DrainaseIrigasiLaporan::with('tindakLanjut')->findOrFail($id);

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

        $row = DrainaseIrigasiLaporanTindakLanjut::firstOrNew([
            'laporan_id' => $laporan->id,
            'status' => $status,
        ]);
        $row->deskripsi = $validated['deskripsi'];
        $row->jenis = $validated['jenis'];
        $row->save();

        // Jenis penanganan berlaku untuk seluruh laporan -> sinkronkan ke semua tahap
        DrainaseIrigasiLaporanTindakLanjut::where('laporan_id', $laporan->id)
            ->update(['jenis' => $validated['jenis']]);

        if (!empty($validated['hapus_foto'])) {
            $fotos = DrainaseIrigasiLaporanTindakLanjutFoto::where('tindak_lanjut_id', $row->id)
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
            ->route('admin.hantu-banyu.laporan.detail', $laporan->id)
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

    private function simpanFoto(Request $request, int $laporanId, DrainaseIrigasiLaporanTindakLanjut $tindak): void
    {
        if (!$request->hasFile('foto')) {
            return;
        }

        $dir = "drainase-irigasi/{$laporanId}/tindak_lanjut";
        foreach ($request->file('foto') as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            $ext = $file->getClientOriginalExtension();
            $namaFoto = "tl{$tindak->id}_" . now()->format('YmdHis') . '_' . uniqid() . ".{$ext}";
            $file->storeAs("public/{$dir}", $namaFoto);
            DrainaseIrigasiLaporanTindakLanjutFoto::create([
                'tindak_lanjut_id' => $tindak->id,
                'foto' => "{$dir}/{$namaFoto}",
            ]);
        }
    }
}
