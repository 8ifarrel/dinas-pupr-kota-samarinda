<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Silalad;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SilaladAdminController extends Controller
{
    /** @deprecated Daftar status kini tunggal di Silalad::STATUS. */
    public const STATUS = Silalad::STATUS;

    /**
     * Potongan URL untuk tiap tahap yang bisa diisi lewat modal (meniru pola
     * Hantu Banyu). Nilai asli Silalad::STATUS berupa kalimat berspasi
     * ("Sedang dikerjakan") sehingga tidak nyaman dipakai langsung sebagai
     * segmen URL - dipetakan ke slug pendek di sini.
     *
     * "Menunggu konfirmasi" sengaja tidak punya slot: tahap itu terisi
     * otomatis saat pesanan dibuat dan tidak ada data admin yang perlu
     * diisi di situ, jadi tidak ada modal untuknya.
     */
    public const SLOT_SLUG = [
        'dijadwalkan' => Silalad::DIJADWALKAN,
        'sedang-dikerjakan' => Silalad::DIKERJAKAN,
        'selesai' => Silalad::SELESAI,
        'dibatalkan' => Silalad::DIBATALKAN,
    ];

    /**
     * Daftar semua pesanan (dulu terpecah jadi "Data Pesanan", "Data
     * Terkonfirmasi", dan "Riwayat Pesanan" yang saling tumpang tindih -
     * digabung jadi satu daftar dengan filter status/bulan/tahun.
     */
    public function dataPesanan(Request $request)
    {
        $status = $request->get('status');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = Silalad::query();

        if ($status) {
            $query->where('status_pengerjaan', $status);
        }
        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $pesanan = $query->orderBy('created_at', 'desc')->get();

        $page_title = 'Daftar Pesanan';

        return view('admin.pages.silalad.daftar-pesanan', compact('pesanan', 'page_title', 'status', 'bulan', 'tahun'));
    }

    /**
     * Tampilkan form edit pesanan.
     *
     * Data yang diisi pelanggan sendiri saat mendaftar ditampilkan sebagai
     * referensi (disabled), bukan untuk diedit. Yang bisa diisi admin adalah
     * status pengerjaan beserta data penugasan & pelaksanaannya - bahan
     * ketiga surat yang bisa dicetak dari halaman ini.
     */
    public function edit(Silalad $silalad)
    {
        $page_title = 'Edit Pesanan';
        $data = $silalad; // agar view pakai $data tetap jalan

        $routeBatal = route('admin.silalad.data-pesanan');
        $namaKecamatan = optional(Kecamatan::find($data->kecamatan_id))->nama ?? $data->kecamatan_id;
        $namaKelurahan = optional(Kelurahan::find($data->kelurahan_id))->nama ?? $data->kelurahan_id;
        $nomorSpkUsulan = $this->usulanNomorSpk();

        // Petakan tiap status ke baris tindak lanjutnya (null bila belum
        // diisi) - pola yang sama dipakai Hantu Banyu, satu baris per status,
        // diedit di tempat alih-alih menumpuk baris baru tiap kali dikoreksi.
        $baris = $silalad->tindakLanjut()->get()->keyBy('status');
        $slot = [];
        foreach (Silalad::STATUS as $s) {
            $slot[$s] = $baris->get($s);
        }

        return view('admin.pages.silalad.edit', compact(
            'page_title',
            'data',
            'routeBatal',
            'namaKecamatan',
            'namaKelurahan',
            'slot',
            'nomorSpkUsulan'
        ) + [
            'editable' => $this->slotEditable($silalad),
            'slotSlug' => array_flip(self::SLOT_SLUG),
        ]);
    }

    /**
     * Isi atau perbarui satu tahap. Tahap diisi berurutan (tahap berikutnya
     * saja yang bisa dibuka), tapi tahap yang sudah terisi tetap bisa diedit
     * kapan saja - satu baris per status di `silalad_tindak_lanjut`, dipakai
     * ulang saat dikoreksi (bukan menumpuk baris baru), mengikuti pola
     * Hantu Banyu. `status_pengerjaan` disinkronkan otomatis ke tahap
     * terjauh yang sudah terisi, supaya penyaringan/statistik/gerbang cetak
     * surat yang membaca kolom itu tidak perlu berubah sama sekali.
     */
    public function simpanSlot(Request $request, Silalad $silalad, string $slug)
    {
        $status = self::SLOT_SLUG[$slug] ?? null;
        abort_if($status === null, 404);

        abort_unless(
            $this->slotEditable($silalad)[$status] ?? false,
            403,
            'Tahap ini belum bisa diisi. Selesaikan tahap sebelumnya dulu.'
        );

        match ($status) {
            Silalad::DIJADWALKAN => $this->isiSlotDijadwalkan($request, $silalad),
            Silalad::SELESAI => $this->isiSlotSelesai($request, $silalad),
            Silalad::DIBATALKAN => $this->isiSlotDibatalkan($request, $silalad),
            // "Sedang dikerjakan" tidak punya data tambahan - tidak ada yang
            // perlu diisi ke $silalad selain baris riwayatnya di bawah.
            default => null,
        };

        $silalad->save();

        $silalad->tindakLanjut()->updateOrCreate(
            ['status' => $status],
            ['keterangan' => $this->keteranganBawaan($silalad, $status)]
        );

        $silalad->update([
            'status_pengerjaan' => $this->hitungStatusTerkini(
                $silalad->tindakLanjut()->pluck('status')->all()
            ),
        ]);

        return redirect()->route('admin.silalad.edit', $silalad->id)
            ->with('success', 'Tahap berhasil disimpan.');
    }

    /**
     * Penugasan operator & kendaraan, sekaligus data untuk Surat Pesanan
     * (jarak tangki, bisa/tidaknya disedot) - keduanya terbit bersamaan saat
     * pesanan dijadwalkan, jadi digabung dalam satu tahap/modal yang sama.
     */
    private function isiSlotDijadwalkan(Request $request, Silalad $silalad): void
    {
        // Checkbox "sama seperti tanggal yang diajukan pelanggan" - dinormalkan
        // dulu (pola yang sama dipakai "setuju" di formulir guest) supaya
        // rule boolean di bawah konsisten walau browser tidak mengirim
        // checkbox yang tidak dicentang.
        $request->merge(['pakai_tanggal_diharapkan' => $request->boolean('pakai_tanggal_diharapkan')]);
        $pakaiTanggalDiharapkan = $request->boolean('pakai_tanggal_diharapkan');

        $validated = $request->validate([
            'nomor_spk' => ['required', 'string', 'max:100'],
            'nama_operator' => ['required', 'string', 'max:150'],
            'nomor_kendaraan' => ['required', 'string', 'max:30'],
            'kapasitas_kendaraan' => ['nullable', 'string', 'max:30'],

            'pakai_tanggal_diharapkan' => ['boolean'],
            'tanggal_pelaksanaan' => [$pakaiTanggalDiharapkan ? 'nullable' : 'required', 'date'],

            'jarak_tangki' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'bisa_disedot' => ['nullable', 'in:1,0'],
        ], [
            'nomor_spk.required' => 'Nomor SPK wajib diisi karena Surat Perintah Kerja terbit pada tahap ini.',
            'nama_operator.required' => 'Nama operator wajib diisi untuk menerbitkan Surat Perintah Kerja.',
            'nomor_kendaraan.required' => 'Nomor kendaraan wajib diisi untuk menerbitkan Surat Perintah Kerja.',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi, atau centang "sama seperti tanggal yang diajukan pelanggan".',
        ]);

        // Checkbox dicentang tapi pesanan ini tidak punya tanggal permintaan
        // pelanggan (mis. pesanan lama, dibuat sebelum isian itu ada) - tidak
        // ada yang bisa disalin, admin harus melepas centang dan memilih
        // tanggal sendiri.
        if ($pakaiTanggalDiharapkan && !$silalad->tanggal_diharapkan) {
            throw ValidationException::withMessages([
                'tanggal_pelaksanaan' => 'Pesanan ini tidak punya tanggal permintaan dari pelanggan - lepas centang lalu pilih tanggal pelaksanaan secara manual.',
            ]);
        }

        $silalad->fill([
            'nomor_spk' => $validated['nomor_spk'],
            'nama_operator' => $validated['nama_operator'],
            'nomor_kendaraan' => $validated['nomor_kendaraan'],
            'kapasitas_kendaraan' => $validated['kapasitas_kendaraan'] ?? null,
            'tanggal_pelaksanaan' => $pakaiTanggalDiharapkan
                ? optional($silalad->tanggal_diharapkan)->toDateString()
                : $validated['tanggal_pelaksanaan'],
            'jarak_tangki' => $validated['jarak_tangki'] ?? null,
            'bisa_disedot' => isset($validated['bisa_disedot']) ? (bool) $validated['bisa_disedot'] : null,

            // Tanggal terbit surat - sekali terisi tidak pernah ditimpa lagi,
            // supaya tanggal di surat cetakan tidak berubah tiap kali admin
            // mengoreksi tahap ini.
            'tanggal_pesanan' => $silalad->tanggal_pesanan ?: now(),
            'tanggal_perintah' => $silalad->tanggal_perintah ?: now(),
        ]);
    }

    /** Jumlah rit jadi dasar penagihan (tarifnya per rit) dan isi Surat Jalan. */
    private function isiSlotSelesai(Request $request, Silalad $silalad): void
    {
        $validated = $request->validate([
            'jumlah_rit' => ['required', 'integer', 'min:1', 'max:255'],
        ], [
            'jumlah_rit.required' => 'Jumlah rit wajib diisi karena jadi dasar penagihan.',
        ]);

        $silalad->fill(['jumlah_rit' => $validated['jumlah_rit']]);
    }

    private function isiSlotDibatalkan(Request $request, Silalad $silalad): void
    {
        $validated = $request->validate([
            'alasan_batal' => ['required', 'string', 'max:500'],
        ], [
            'alasan_batal.required' => 'Alasan pembatalan wajib diisi.',
        ]);

        $silalad->fill(['alasan_batal' => $validated['alasan_batal']]);
    }

    /**
     * Tahap mana yang boleh diisi/diedit, meniru aturan Hantu Banyu:
     *  - tahap yang sudah terisi -> boleh diedit (koreksi)
     *  - satu tahap tepat setelah tahap terjauh pada alur utama -> boleh diisi
     *  - "Dibatalkan" di luar alur utama: boleh diisi kapan saja selama
     *    pesanan belum "Selesai" (pekerjaan yang sudah tuntas tidak boleh
     *    dibatalkan lagi), dan mengunci alur utama begitu terisi (pesanan
     *    yang batal tidak boleh lanjut dijadwalkan/dikerjakan).
     *
     * @return array<string,bool>
     */
    private function slotEditable(Silalad $silalad): array
    {
        $terisi = $silalad->tindakLanjut()->pluck('status')->all();
        $utama = array_keys(Silalad::TAHAP); // Menunggu, Dijadwalkan, Dikerjakan, Selesai - berurutan

        $furthest = -1;
        foreach ($utama as $i => $s) {
            if (in_array($s, $terisi, true)) {
                $furthest = $i;
            }
        }
        $next = $furthest + 1;
        $dibatalkanTerisi = in_array(Silalad::DIBATALKAN, $terisi, true);
        $selesaiTerisi = in_array(Silalad::SELESAI, $terisi, true);

        $map = [];
        foreach ($utama as $i => $s) {
            $map[$s] = in_array($s, $terisi, true) || ($i === $next && !$dibatalkanTerisi);
        }
        $map[Silalad::DIBATALKAN] = $dibatalkanTerisi || !$selesaiTerisi;

        return $map;
    }

    /** Status terkini = "Dibatalkan" bila sudah diisi, atau tahap utama terjauh yang sudah terisi. */
    private function hitungStatusTerkini(array $terisi): string
    {
        if (in_array(Silalad::DIBATALKAN, $terisi, true)) {
            return Silalad::DIBATALKAN;
        }

        $hasil = Silalad::MENUNGGU;
        foreach (array_keys(Silalad::TAHAP) as $s) {
            if (in_array($s, $terisi, true)) {
                $hasil = $s;
            }
        }
        return $hasil;
    }

    /**
     * Keterangan riwayat untuk satu tahap - selalu dirangkai otomatis dari
     * data yang baru saja diisi di tahap tersebut, admin tidak menuliskannya
     * sendiri. $status diterima eksplisit (bukan dibaca dari
     * $silalad->status_pengerjaan) supaya tidak bergantung urutan pemanggilan.
     */
    private function keteranganBawaan(Silalad $silalad, string $status): string
    {
        return match ($status) {
            Silalad::DIJADWALKAN => trim('Pesanan dikonfirmasi dan ditugaskan kepada '
                . ($silalad->nama_operator ?: 'petugas')
                . ($silalad->nomor_kendaraan ? ' (kendaraan ' . $silalad->nomor_kendaraan . ')' : '')
                // tanggal_pelaksanaan, BUKAN tanggal_perintah - yang terakhir
                // itu tanggal terbit SPK, bukan jadwal penyedotannya.
                . ($silalad->tanggal_pelaksanaan ? ', dijadwalkan ' . $silalad->tanggal_pelaksanaan->translatedFormat('d F Y') : '')
                . '.'),
            Silalad::DIKERJAKAN => 'Petugas sedang mengerjakan penyedotan di lokasi.',
            Silalad::SELESAI => 'Penyedotan selesai dikerjakan'
                . ($silalad->jumlah_rit ? ' sebanyak ' . $silalad->jumlah_rit . ' rit' : '') . '.',
            Silalad::DIBATALKAN => trim('Pesanan dibatalkan. ' . ($silalad->alasan_batal ?: '')),
            default => 'Pesanan diterima dan menunggu dijadwalkan.',
        };
    }

    /**
     * Usulan nomor SPK untuk mengisi otomatis kotak isian di halaman edit.
     * Sekadar usulan - admin tetap bebas mengetik format lain, karena aturan
     * penomoran resminya ditentukan UPTD, bukan aplikasi ini.
     */
    private function usulanNomorSpk(): string
    {
        $romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $tahun = now()->year;

        $terpakai = Silalad::whereYear('created_at', $tahun)
            ->whereNotNull('nomor_spk')
            ->count();

        return str_pad($terpakai + 1, 3, '0', STR_PAD_LEFT)
            . '/UPTD/' . $romawi[now()->month - 1] . '/' . $tahun;
    }

        public function update(Request $request, Silalad $silalad)
    {
        // handle checkbox
        $request->merge(['setuju' => $request->has('setuju')]);

        // validasi
        $validated = $this->validateRequest($request);

        // update data
        $silalad->update($validated);

        return redirect()
            ->route('admin.silalad.data-pesanan')
            ->with('success', 'Pesanan berhasil diupdate.');
    }


    /**
     * Hapus pesanan
     */
    public function destroy(Silalad $silalad)
    {
        $silalad->delete();

        return redirect()->route('admin.silalad.data-pesanan')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Bukti pesanan - tanda terima dari UPTD untuk pelanggan. Selalu bisa
     * dicetak karena datanya sudah lengkap sejak pesanan masuk.
     */
    public function print(Silalad $silalad)
    {
        return view('admin.pages.silalad.print', [
            'item' => $silalad,
            'page_title' => 'Cetak Pesanan',
        ]);
    }

    /**
     * Surat Pesanan - permohonan yang ditandatangani pelanggan, memuat hasil
     * pemeriksaan di lokasi (jarak tangki, bisa/tidaknya disedot). Terbit
     * bersama Surat Perintah Kerja pada tahap "Dijadwalkan", lalu dibawa
     * petugas ke lapangan: bagian yang belum diisi tampil bergaris titik-titik
     * supaya bisa dilengkapi tulisan tangan di lokasi.
     */
    public function printSuratPesanan(Silalad $silalad)
    {
        abort_unless(
            $silalad->suratPenugasanTerbit(),
            404,
            'Surat Pesanan baru bisa dicetak setelah pesanan dijadwalkan.'
        );

        return view('admin.pages.silalad.surat-pesanan', [
            'item' => $silalad,
            'page_title' => 'Surat Pesanan',
            'namaKecamatan' => optional(Kecamatan::find($silalad->kecamatan_id))->nama ?? $silalad->kecamatan_id,
            'namaKelurahan' => optional(Kelurahan::find($silalad->kelurahan_id))->nama ?? $silalad->kelurahan_id,
        ]);
    }

    /**
     * Surat Perintah Kerja - penugasan operator & kendaraan, terbit pada tahap
     * "Dijadwalkan". Dikunci sebelum itu karena isinya belum ada.
     */
    public function printSuratPerintahKerja(Silalad $silalad)
    {
        abort_unless(
            $silalad->suratPenugasanTerbit() && $silalad->nama_operator,
            404,
            'Surat Perintah Kerja baru bisa dicetak setelah pesanan dijadwalkan dan ditugaskan ke operator.'
        );

        return view('admin.pages.silalad.surat-perintah-kerja', [
            'item' => $silalad,
            'page_title' => 'Surat Perintah Kerja',
        ]);
    }

    /**
     * Surat Jalan - catatan pelaksanaan yang dibawa petugas, memuat jumlah
     * rit. Dikunci sampai pekerjaannya dinyatakan selesai.
     */
    public function printSuratJalan(Silalad $silalad)
    {
        abort_if(
            $silalad->status_pengerjaan !== Silalad::SELESAI,
            404,
            'Surat Jalan baru bisa dicetak setelah pekerjaan selesai.'
        );

        return view('admin.pages.silalad.surat-jalan', [
            'item' => $silalad,
            'page_title' => 'Surat Jalan',
            'namaKecamatan' => optional(Kecamatan::find($silalad->kecamatan_id))->nama ?? $silalad->kecamatan_id,
            'namaKelurahan' => optional(Kelurahan::find($silalad->kelurahan_id))->nama ?? $silalad->kelurahan_id,
        ]);
    }

    /**
     * Validasi request untuk store/update.
     *
     * Form punya dua kotak terpisah "Kritik" dan "Saran", tapi kolom
     * fisiknya di tabel cuma satu (saran_masukan) - lihat catatan di
     * edit(). Supaya isian admin tidak hilang diam-diam saat disimpan
     * (kritik/saran sebelumnya bukan kolom yang ada, jadi otomatis
     * dibuang oleh mass assignment), keduanya digabung jadi satu di sini.
     */
    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan'             => 'required|string|max:255',
            'nomor_telepon_pelanggan'   => 'required|string|max:20',
            'alamat'                    => 'required|string',
            'alamat_detail'             => 'nullable|string',
            'layanan'                   => 'required|string',
            'detail_laporan'            => 'nullable|string',
            'kabkota_id'                => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'longitude'                 => 'nullable|numeric',
            'latitude'                  => 'nullable|numeric',
            'jenis_bangunan'            => 'required|string',
            'nomor_bangunan'            => 'required|numeric',
            'rt'                        => 'required|numeric',
            'rating'                    => 'nullable|numeric|min:1|max:5',
            'kritik'                    => 'nullable|string',
            'saran'                     => 'nullable|string',
            'status_pengerjaan'         => 'required|string',
            'setuju'                    => 'boolean',
        ]);

        $validated['saran_masukan'] = collect([$validated['kritik'] ?? null, $validated['saran'] ?? null])
            ->filter()
            ->implode("\n");
        unset($validated['kritik'], $validated['saran']);

        return $validated;
    }


}