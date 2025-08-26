<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SedotTinja;
use Illuminate\Http\Request;

class SedotTinjaAdminController extends Controller
{
    /**
     * Index semua pesanan
     */
    public function index()
    {
        $pesanan = SedotTinja::orderBy('created_at', 'desc')->paginate(10);
        $page_title = 'Semua Pesanan';

        return view('admin.pages.sedot-tinja.index', compact('pesanan', 'page_title'));
    }

    /**
     * Pesanan masuk (Belum dikerjakan)
     */
    public function dataPesanan()
    {
        $pesananPending = SedotTinja::where('status_pengerjaan', 'Belum dikerjakan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $page_title = 'Data Pesanan Masuk';

        return view('admin.pages.sedot-tinja.data-pesanan', compact('pesananPending', 'page_title'));
    }

    /**
     * Pesanan terkonfirmasi (Sedang dikerjakan atau Sudah dikerjakan)
     */
    public function dataTerkonfirmasi(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = SedotTinja::whereIn('status_pengerjaan', ['Sedang dikerjakan', 'Sudah dikerjakan']);

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $pesananConfirmed = $query->orderBy('updated_at', 'desc')->paginate(10);

        $page_title = 'Data Terkonfirmasi';

        return view('admin.pages.sedot-tinja.data-terkonfirmasi', compact('pesananConfirmed', 'page_title', 'bulan', 'tahun'));
    }

    /**
     * Riwayat semua pesanan
     */
    public function riwayatPesanan()
    {
        $riwayat = SedotTinja::orderBy('updated_at', 'desc')->paginate(10);

        $page_title = 'Riwayat Pesanan';

        return view('admin.pages.sedot-tinja.riwayat-pesanan', compact('riwayat', 'page_title'));
    }

    /**
     * Tampilkan form buat pesanan baru
     */
    public function create()
    {
        $page_title = 'Buat Pesanan Baru';
        return view('admin.pages.sedot-tinja.create', compact('page_title'));
    }

    /**
     * Simpan pesanan baru ke database
     */
    public function store(Request $request)
    {
        // Handle checkbox 'setuju'
        $request->merge(['setuju' => $request->has('setuju')]);

        $validated = $this->validateRequest($request);

        SedotTinja::create($validated);

        return redirect()->route('admin.sedot-tinja.dataPesanan')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show(SedotTinja $sedotTinja)
    {
        $page_title = 'Detail Pesanan';
        return view('admin.pages.sedot-tinja.show', compact('sedotTinja', 'page_title'));
    }

    /**
     * Tampilkan form edit pesanan
     */
    public function edit(SedotTinja $sedotTinja)
    {
        $page_title = 'Edit Pesanan';
        return view('admin.pages.sedot-tinja.edit', compact('sedotTinja', 'page_title'));
    }

    /**
     * Update pesanan di database
     */
    public function update(Request $request, SedotTinja $sedotTinja)
    {
        // Handle checkbox 'setuju'
        $request->merge(['setuju' => $request->has('setuju')]);

        $validated = $this->validateRequest($request);

        $sedotTinja->update($validated);

        return redirect()->route('admin.sedot-tinja.dataPesanan')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Hapus pesanan
     */
    public function destroy(SedotTinja $sedotTinja)
    {
        $sedotTinja->delete();

        return redirect()->route('admin.sedot-tinja.dataPesanan')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Cetak pesanan
     */
    public function print(SedotTinja $sedotTinja)
    {
        $page_title = 'Cetak Pesanan';
        return view('admin.pages.sedot-tinja.print', compact('sedotTinja', 'page_title'));
    }

    /**
     * Validasi request untuk store/update
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'nama_pelanggan'          => 'required|string|max:150',
            'nomor_telepon_pelanggan' => 'required|string|max:15',
            'alamat'                  => 'required|string',
            'layanan'                 => 'nullable|string|max:50',
            'detail_laporan'          => 'nullable|string',
            'kabkota_id'              => 'required|exists:kabkotas,id',
            'kecamatan_id'            => 'required|exists:kecamatans,id',
            'kelurahan_id'            => 'required|exists:kelurahans,id',
            'latitude'                => 'nullable|numeric',
            'longitude'               => 'nullable|numeric',
            'jenis_bangunan'          => 'required|string|max:50',
            'alamat_detail'           => 'nullable|string',
            'nomor_bangunan'          => 'required|integer',
            'rt'                      => 'required|integer',
            'rating'                  => 'nullable|integer|min:1|max:5',
            'kritik'                  => 'nullable|string',
            'saran'                   => 'nullable|string',
            'status_pengerjaan'       => 'required|in:Belum dikerjakan,Sedang dikerjakan,Sudah dikerjakan',
            'setuju'                  => 'boolean',
        ]);
    }


    /**
     * Cetak Surat Jalan
     */
    public function printSuratJalan(SedotTinja $sedotTinja)
    {
        return view('admin.pages.sedot-tinja.print-surat-jalan', compact('sedotTinja'));
    }

    /**
     * Cetak Surat Pernyataan Kerja
     */
    public function printSuratPernyataan(SedotTinja $sedotTinja)
    {
        return view('admin.pages.sedot-tinja.print-surat-pernyataan', compact('sedotTinja'));
    }

    /**
     * Cetak Surat Pesanan
     */
    public function printSuratPesanan(SedotTinja $sedotTinja)
    {
        return view('admin.pages.sedot-tinja.print-surat-pesanan', compact('sedotTinja'));
    }
  }