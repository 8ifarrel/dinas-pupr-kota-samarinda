<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SedotTinja;
use Illuminate\Http\Request;

class SedotTinjaAdminController extends Controller
{
    /**
     * Pesanan masuk (Belum dikerjakan)
     */
    public function dataPesanan()
    {
        $pesananPending = SedotTinja::where('status_pengerjaan', 'Belum dikerjakan')
            ->orderBy('created_at', 'desc')
            ->get();

        $page_title = 'Data Pesanan';

        return view('admin.pages.sedot-tinja.data-pesanan', compact('pesananPending', 'page_title'));
    }

    /**
     * Pesanan terkonfirmasi (Sedang dikerjakan atau Sudah dikerjakan)
     */
    public function dataTerkonfirmasi()
    {
        $pesananConfirmed = SedotTinja::whereIn('status_pengerjaan', ['Sedang dikerjakan', 'Sudah dikerjakan'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $page_title = 'Data Terkonfirmasi';

        return view('admin.pages.sedot-tinja.data-terkonfirmasi', compact('pesananConfirmed', 'page_title'));
    }

    /**
     * Riwayat semua pesanan
     */
    public function riwayatPesanan()
    {
        $riwayat = SedotTinja::orderBy('updated_at', 'desc')->get();

        $page_title = 'Riwayat Pesanan';
        
        return view('admin.pages.sedot-tinja.riwayat-pesanan', compact('riwayat', 'page_title'));
    }

    /**
     * Tampilkan form buat pesanan baru.
     */
    public function create()
    {
        return view('admin.pages.sedot-tinja.create');
    }

    /**
     * Simpan pesanan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        SedotTinja::create($validated);

        return redirect()->route('admin.sedot-tinja.data-pesanan')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Tampilkan detail pesanan.
     */
    public function show(SedotTinja $sedotTinja)
    {
        return view('admin.pages.sedot-tinja.show', compact('sedotTinja', 'page_title'));
    }

    /**
     * Tampilkan form edit pesanan.
     */
    public function edit(SedotTinja $sedotTinja)
    {
        return view('admin.pages.sedot-tinja.edit', compact('sedotTinja', 'page_title'));
    }

    /**
     * Update pesanan di database.
     */
    public function update(Request $request, SedotTinja $sedotTinja)
    {
        $validated = $this->validateRequest($request);

        $sedotTinja->update($validated);

        return redirect()->route('admin.sedot-tinja.data-pesanan')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Hapus pesanan.
     */
    public function destroy(SedotTinja $sedotTinja)
    {
        $sedotTinja->delete();

        return redirect()->route('admin.sedot-tinja.data-pesanan')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Validasi request untuk store/update
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'nama_pelanggan' => 'required|string|max:150',
            'nomor_telepon_pelanggan' => 'required|string|max:15',
            'alamat' => 'required|string',
            'layanan' => 'nullable|string|max:50',
            'detail_laporan' => 'nullable|string',
            'kabkota_id' => 'required|string|max:50',
            'kecamatan_id' => 'required|string|max:50',
            'kelurahan_id' => 'required|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jenis_bangunan' => 'required|string|max:50',
            'alamat_detail' => 'nullable|string',
            'nomor_bangunan' => 'required|integer',
            'rt' => 'required|integer',
            'rating' => 'nullable|integer|min:1|max:5',
            'kritik' => 'nullable|string',
            'saran' => 'nullable|string',
            'captcha' => 'nullable|string|max:50',
            'status_pengerjaan' => 'required|in:Belum dikerjakan,Sedang dikerjakan,Sudah dikerjakan',
            'setuju' => 'boolean',
        ]);
    }
}
