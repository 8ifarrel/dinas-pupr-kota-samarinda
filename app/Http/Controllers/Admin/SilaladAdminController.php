<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Silalad;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class SilaladAdminController extends Controller
{
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
     * Satu-satunya yang benar-benar bisa diubah admin di sini adalah status
     * pengerjaan - seluruh data lain diisi pelanggan sendiri saat mendaftar
     * dan ditampilkan sebagai referensi (disabled), bukan untuk diedit.
     */
    public function edit(Silalad $silalad)
    {
        $page_title = 'Edit Pesanan';
        $data = $silalad; // agar view pakai $data tetap jalan

        $routeBatal = route('admin.silalad.data-pesanan');
        $namaKecamatan = optional(Kecamatan::find($data->kecamatan_id))->nama ?? $data->kecamatan_id;
        $namaKelurahan = optional(Kelurahan::find($data->kelurahan_id))->nama ?? $data->kelurahan_id;

        return view('admin.pages.silalad.edit', compact('page_title', 'data', 'routeBatal', 'namaKecamatan', 'namaKelurahan'));
    }


    /**
     * Update pesanan di database
     */
    public function updateStatus(Request $request, Silalad $silalad)
    {
        $request->validate([
            'status_pengerjaan' => 'required|in:Belum dikerjakan,Sedang dikerjakan,Sudah dikerjakan,Dibatalkan',
        ]);

        $silalad->status_pengerjaan = $request->status_pengerjaan;
        $silalad->save();

        return redirect()->route('admin.silalad.data-pesanan')
            ->with('success', 'Status pesanan berhasil diperbarui.');
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

    // /**
    //  * Cetak pesanan
    //  */
    public function print(Silalad $silalad)
     {
        $page_title = 'Cetak Pesanan';
        return view('admin.pages.silalad.print', [
    'item' => $silalad,
    'page_title' => $page_title,
    
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