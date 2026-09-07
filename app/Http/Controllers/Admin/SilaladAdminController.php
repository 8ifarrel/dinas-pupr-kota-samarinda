<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Silalad;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class SilaladAdminController extends Controller
{
    public const STATUS = ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'];

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
        $riwayat = $silalad->tindakLanjut()->orderBy('created_at')->orderBy('id')->get();
        $nomorSpkUsulan = $this->usulanNomorSpk();

        return view('admin.pages.silalad.edit', compact(
            'page_title',
            'data',
            'routeBatal',
            'namaKecamatan',
            'namaKelurahan',
            'riwayat',
            'nomorSpkUsulan'
        ));
    }


    /**
     * Simpan status pengerjaan beserta data penugasan & pelaksanaannya.
     *
     * Perubahan status tidak menimpa status sebelumnya begitu saja: tiap
     * perubahan dicatat sebagai baris baru di `silalad_tindak_lanjut`,
     * sehingga perjalanan pesanan bisa dipantau (pola yang sama dipakai
     * Hantu Banyu). Kolom `status_pengerjaan` tetap menyimpan status terkini
     * supaya penyaringan dan statistik tidak perlu menelusuri riwayat.
     */
    public function updateStatus(Request $request, Silalad $silalad)
    {
        $status = $request->input('status_pengerjaan');

        $validated = $request->validate([
            'status_pengerjaan' => 'required|in:' . implode(',', self::STATUS),
            'keterangan' => 'nullable|string|max:500',

            // Survei kelayakan
            'nomor_spk' => 'nullable|string|max:100',
            'jarak_tangki' => 'nullable|integer|min:0|max:65535',
            'bisa_disedot' => 'nullable|in:1,0',
            'tanggal_pesanan' => 'nullable|date',

            // Penugasan - wajib begitu pesanan mulai dikerjakan, karena
            // Surat Perintah Kerja tidak ada artinya tanpa ketiganya.
            'nama_operator' => [$status === 'Sedang dikerjakan' ? 'required' : 'nullable', 'string', 'max:150'],
            'nomor_kendaraan' => [$status === 'Sedang dikerjakan' ? 'required' : 'nullable', 'string', 'max:30'],
            'kapasitas_kendaraan' => 'nullable|string|max:30',
            'tanggal_perintah' => [$status === 'Sedang dikerjakan' ? 'required' : 'nullable', 'date'],

            // Pelaksanaan - jumlah rit jadi dasar penagihan (tarifnya per
            // rit), jadi wajib begitu pekerjaan dinyatakan selesai.
            'jumlah_rit' => [$status === 'Sudah dikerjakan' ? 'required' : 'nullable', 'integer', 'min:1', 'max:255'],
            'tanggal_jalan' => 'nullable|date',

            'alasan_batal' => [$status === 'Dibatalkan' ? 'required' : 'nullable', 'string', 'max:500'],
        ], [
            'nama_operator.required' => 'Nama operator wajib diisi untuk menerbitkan Surat Perintah Kerja.',
            'nomor_kendaraan.required' => 'Nomor kendaraan wajib diisi untuk menerbitkan Surat Perintah Kerja.',
            'tanggal_perintah.required' => 'Tanggal perintah kerja wajib diisi.',
            'jumlah_rit.required' => 'Jumlah rit wajib diisi karena jadi dasar penagihan.',
            'alasan_batal.required' => 'Alasan pembatalan wajib diisi.',
        ]);

        $statusLama = $silalad->status_pengerjaan;

        $silalad->fill([
            'status_pengerjaan' => $validated['status_pengerjaan'],
            'nomor_spk' => $validated['nomor_spk'] ?? null,
            'jarak_tangki' => $validated['jarak_tangki'] ?? null,
            'bisa_disedot' => isset($validated['bisa_disedot']) ? (bool) $validated['bisa_disedot'] : null,
            'tanggal_pesanan' => $validated['tanggal_pesanan'] ?? null,
            'nama_operator' => $validated['nama_operator'] ?? null,
            'nomor_kendaraan' => $validated['nomor_kendaraan'] ?? null,
            'kapasitas_kendaraan' => $validated['kapasitas_kendaraan'] ?? null,
            'tanggal_perintah' => $validated['tanggal_perintah'] ?? null,
            'jumlah_rit' => $validated['jumlah_rit'] ?? null,
            'tanggal_jalan' => $validated['tanggal_jalan'] ?? null,
            'alasan_batal' => $validated['alasan_batal'] ?? null,
        ])->save();

        // Riwayat hanya ditambah bila statusnya benar-benar berpindah -
        // menyimpan ulang data penugasan tanpa ganti status bukan peristiwa
        // yang perlu dicatat sebagai tahap baru.
        if ($statusLama !== $silalad->status_pengerjaan) {
            $silalad->tindakLanjut()->create([
                'status' => $silalad->status_pengerjaan,
                'keterangan' => ($validated['keterangan'] ?? null)
                    ?: $this->keteranganBawaan($silalad),
            ]);
        }

        return redirect()->route('admin.silalad.data-pesanan')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Keterangan riwayat bila admin tidak menuliskannya sendiri, dirangkai
     * dari data yang baru saja diisi supaya riwayatnya tetap informatif.
     */
    private function keteranganBawaan(Silalad $silalad): string
    {
        return match ($silalad->status_pengerjaan) {
            'Sedang dikerjakan' => trim('Pesanan dikonfirmasi dan ditugaskan kepada '
                . ($silalad->nama_operator ?: 'petugas')
                . ($silalad->nomor_kendaraan ? ' (kendaraan ' . $silalad->nomor_kendaraan . ')' : '') . '.'),
            'Sudah dikerjakan' => 'Penyedotan selesai dikerjakan'
                . ($silalad->jumlah_rit ? ' sebanyak ' . $silalad->jumlah_rit . ' rit' : '') . '.',
            'Dibatalkan' => 'Pesanan dibatalkan. ' . ($silalad->alasan_batal ?: ''),
            default => 'Pesanan dikembalikan ke daftar menunggu.',
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
     * pemeriksaan kelayakan (jarak tangki, bisa/tidaknya disedot). Boleh
     * dicetak kapan saja: bagian yang belum diisi tampil bergaris titik-titik
     * supaya bisa dilengkapi tulisan tangan saat petugas ke lapangan.
     */
    public function printSuratPesanan(Silalad $silalad)
    {
        return view('admin.pages.silalad.surat-pesanan', [
            'item' => $silalad,
            'page_title' => 'Surat Pesanan',
            'namaKecamatan' => optional(Kecamatan::find($silalad->kecamatan_id))->nama ?? $silalad->kecamatan_id,
            'namaKelurahan' => optional(Kelurahan::find($silalad->kelurahan_id))->nama ?? $silalad->kelurahan_id,
        ]);
    }

    /**
     * Surat Perintah Kerja - penugasan operator & kendaraan. Baru berarti
     * setelah pesanan dikonfirmasi, jadi dikunci sampai statusnya berpindah
     * dari "Belum dikerjakan".
     */
    public function printSuratPerintahKerja(Silalad $silalad)
    {
        abort_if(
            $silalad->status_pengerjaan === 'Belum dikerjakan' || !$silalad->nama_operator,
            404,
            'Surat Perintah Kerja baru bisa dicetak setelah pesanan ditugaskan ke operator.'
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
            $silalad->status_pengerjaan !== 'Sudah dikerjakan',
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