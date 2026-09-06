<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Silalad;
use Illuminate\Http\Request;

class SilaladAdminController extends Controller

{
    // /**
    //  * Index semua pesanan
    //  */
    //  public function index()
    //  {
    //      $pesananPending = Silalad::orderBy('created_at', 'desc')->paginate(10);
    //      $page_title = 'Semua Pesanan';
        

    //      return view('admin.pages.silalad.index', compact('pesananPending', 'page_title'));
    //  }

    /**
     * Pesanan masuk (Belum dikerjakan)
     */
    public function dataPesanan()
    {
        $pesananPending = Silalad::where('status_pengerjaan', 'Belum dikerjakan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $page_title = 'Data Pesanan Masuk';

        
        return view('admin.pages.silalad.data-pesanan', compact('pesananPending', 'page_title'));
    }

    /**
     * Pesanan terkonfirmasi (Sedang dikerjakan atau Sudah dikerjakan)
     */
    public function dataTerkonfirmasi(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = Silalad::whereIn('status_pengerjaan', ['Sedang dikerjakan', 'Sudah dikerjakan']);

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }
        $pesananConfirmed = $query->orderBy('updated_at', 'desc')->paginate(10);

        $page_title = 'Data Terkonfirmasi';
        return view('admin.pages.silalad.data-terkonfirmasi', compact( 'pesananConfirmed', 'page_title', 'bulan', 'tahun'));
    }
    /**
     * Riwayat semua pesanan
     */
    public function riwayatPesanan()
    {
        $riwayat = Silalad::orderBy('updated_at', 'desc')->paginate(10);

        $page_title = 'Riwayat Pesanan';

        return view('admin.pages.silalad.riwayat-pesanan', compact('riwayat', 'page_title'));
    }

    /**
     * Tampilkan form buat pesanan baru
     */
    public function create()
    {
        $page_title = 'Buat Pesanan Baru';
        return view('admin.pages.silalad.create', compact('page_title'));
    }

    /**
     * Simpan pesanan baru ke database
     */
    public function store(Request $request)
    {
        // Handle checkbox 'setuju'
        $request->merge(['setuju' => $request->has('setuju')]);

        $validated = $this->validateRequest($request);

        Silalad::create($validated);

        return redirect()->route('admin.silalad.data-pesanan')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show(Silalad $silalad)
    {
        $page_title = 'Detail Pesanan';

        // Lihat catatan di edit() soal kritik/saran vs kolom asli saran_masukan.
        $silalad->kritik = $silalad->saran_masukan;
        $silalad->saran = $silalad->saran_masukan;

        return view('admin.pages.silalad.show', compact('silalad', 'page_title'));
    }

    /**
     * Tampilkan form edit pesanan
     */
    public function edit(Silalad $silalad)
    {
        $page_title = 'Edit Pesanan';
        $page_description = 'Form untuk mengedit data pesanan';
        $data = $silalad; // agar view pakai $data tetap jalan

        // Kolom fisiknya cuma satu (saran_masukan), tapi form punya dua kotak
        // terpisah (Kritik & Saran) peninggalan desain awal. Supaya isinya
        // tidak hilang diam-diam, kedua kotak ditampilkan dari nilai yang sama
        // dan digabung kembali saat disimpan - lihat validateRequest().
        $data->kritik = $data->saran_masukan;
        $data->saran = $data->saran_masukan;

        $routeBatal = route('admin.silalad.data-pesanan');

        return view('admin.pages.silalad.edit', compact('page_title', 'page_description', 'data', 'routeBatal'));
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

        switch ($silalad->status_pengerjaan) {
            case 'Belum dikerjakan':
                return redirect()->route('admin.silalad.data-pesanan')
                    ->with('success', 'Pesanan dikembalikan ke daftar pending.');
            case 'Sedang dikerjakan':
                return redirect()->route('admin.silalad.dataTerkonfirmasi')
                    ->with('success', 'Pesanan berhasil dikonfirmasi.');
            case 'Sudah dikerjakan':
            case 'Dibatalkan':
                return redirect()->route('admin.silalad.riwayat-pesanan')
                    ->with('success', 'Status pesanan dipindahkan ke riwayat.');
        }
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


    /**
     * Cetak Surat Jalan
     */
//     public function printSuratJalan(Silalad $silalad)
//     {
//         return view('admin.pages.silalad.print-surat-jalan', compact('silalad'));
//     }

//     /**
//      * Cetak Surat Pernyataan Kerja
//      */
//     public function printSuratPernyataan(Silalad $silalad)
//     {
//         return view('admin.pages.silalad.print-surat-pernyataan', compact('silalad'));
//     }

//     /**
//      * Cetak Surat Pesanan
//      */
//     public function printSuratPesanan(Silalad $silalad)
//     {
//         return view('admin.pages.silalad.print-surat-pesanan', compact('silalad'));
//     }
//   }

//   public function print(Silalad $silalad, Request $request)
//     {
//         $type = $request->get('type', ); 

//         switch ($type) {
//             case 'pesanan':
//                 return view('admin.pages.silalad.surat-pesanan', [
//                     'item' => $silalad,
//                     'page_title' => 'Surat Pesanan'
//                 ]);
//             case 'jalan':
//                 return view('admin.pages.silalad.surat-jalan', [
//                     'item' => $silalad,
//                     'page_title' => 'Surat Jalan'
//                 ]);
//             default:
//                 return view('admin.pages.silalad.surat-perintah-kerja', [
//                     'item' => $silalad,
//                     'page_title' => 'Surat Perintah Kerja'
//                 ]);
//         }
//     }
}