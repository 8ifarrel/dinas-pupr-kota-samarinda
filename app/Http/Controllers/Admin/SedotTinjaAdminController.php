<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SedotTinja;
use Illuminate\Http\Request;

class SedotTinjaAdminController extends Controller

{
    // /**
    //  * Index semua pesanan
    //  */
    //  public function index()
    //  {
    //      $pesananPending = SedotTinja::orderBy('created_at', 'desc')->paginate(10);
    //      $page_title = 'Semua Pesanan';
        

    //      return view('admin.pages.sedot-tinja.index', compact('pesananPending', 'page_title'));
    //  }

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
        return view('admin.pages.sedot-tinja.data-terkonfirmasi', compact( 'pesananConfirmed', 'page_title', 'bulan', 'tahun'));
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
        $page_description = 'Form untuk mengedit data pesanan';
        $data = $sedotTinja; // agar view pakai $data tetap jalan

        $routeBatal = route('admin.sedot-tinja.data-pesanan');

        return view('admin.pages.sedot-tinja.edit', compact('page_title', 'page_description', 'data', 'routeBatal'));


        return view('admin.pages.sedot-tinja.edit', compact('page_title', 'page_description', 'data'));
}


    /**
     * Update pesanan di database
     */
    public function updateStatus(Request $request, SedotTinja $sedotTinja)
    {
        $request->validate([
            'status_pengerjaan' => 'required|in:Belum dikerjakan,Sedang dikerjakan,Sudah dikerjakan,Dibatalkan',
        ]);

        $sedotTinja->status_pengerjaan = $request->status_pengerjaan;
        $sedotTinja->save();

        switch ($sedotTinja->status_pengerjaan) {
            case 'Belum dikerjakan':
                return redirect()->route('admin.sedot-tinja.data-pesanan')
                    ->with('success', 'Pesanan dikembalikan ke daftar pending.');
            case 'Sedang dikerjakan':
                return redirect()->route('admin.sedot-tinja.dataTerkonfirmasi')
                    ->with('success', 'Pesanan berhasil dikonfirmasi.');
            case 'Sudah dikerjakan':
            case 'Dibatalkan':
                return redirect()->route('admin.sedot-tinja.riwayat-pesanan')
                    ->with('success', 'Status pesanan dipindahkan ke riwayat.');
        }
    }

        public function update(Request $request, SedotTinja $sedotTinja)
    {
        // handle checkbox
        $request->merge(['setuju' => $request->has('setuju')]);

        // validasi
        $validated = $this->validateRequest($request);

        // update data
        $sedotTinja->update($validated);

        return redirect()
            ->route('admin.sedot-tinja.data-pesanan')
            ->with('success', 'Pesanan berhasil diupdate.');
    }


    /**
     * Hapus pesanan
     */
    public function destroy(SedotTinja $sedotTinja)
    {
        $sedotTinja->delete();

        return redirect()->route('admin.sedot-tinja.data-pesanan')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    // /**
    //  * Cetak pesanan
    //  */
    public function print(SedotTinja $sedotTinja)
     {
        $page_title = 'Cetak Pesanan';
        return view('admin.pages.sedot-tinja.print', [
    'item' => $sedotTinja,
    'page_title' => $page_title,
    
]);

     }

    // /**
    //  * Validasi request untuk store/update
    //  */
    private function validateRequest(Request $request)
    {
        return $request->validate([
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
            'jenis_bangunan'            => 'nullable|string',
            'nomor_bangunan'            => 'nullable|numeric',
            'rt'                        => 'nullable|numeric',
            'rating'                    => 'nullable|numeric|min:1|max:5',
            'kritik'                    => 'nullable|string',
            'saran'                     => 'nullable|string',
            'status_pengerjaan'         => 'required|string',
            'setuju'                    => 'boolean',


        ]);

        $data = SedotTinja::findOrFail($id);

        $data->update($request->all());

        return redirect()
            ->route('admin.sedot-tinja.data-pesanan')
            ->with('success', 'Data berhasil diupdate!');
    }


    /**
     * Cetak Surat Jalan
     */
//     public function printSuratJalan(SedotTinja $sedotTinja)
//     {
//         return view('admin.pages.sedot-tinja.print-surat-jalan', compact('sedotTinja'));
//     }

//     /**
//      * Cetak Surat Pernyataan Kerja
//      */
//     public function printSuratPernyataan(SedotTinja $sedotTinja)
//     {
//         return view('admin.pages.sedot-tinja.print-surat-pernyataan', compact('sedotTinja'));
//     }

//     /**
//      * Cetak Surat Pesanan
//      */
//     public function printSuratPesanan(SedotTinja $sedotTinja)
//     {
//         return view('admin.pages.sedot-tinja.print-surat-pesanan', compact('sedotTinja'));
//     }
//   }

//   public function print(SedotTinja $sedotTinja, Request $request)
//     {
//         $type = $request->get('type', ); 

//         switch ($type) {
//             case 'pesanan':
//                 return view('admin.pages.sedot-tinja.surat-pesanan', [
//                     'item' => $sedotTinja,
//                     'page_title' => 'Surat Pesanan'
//                 ]);
//             case 'jalan':
//                 return view('admin.pages.sedot-tinja.surat-jalan', [
//                     'item' => $sedotTinja,
//                     'page_title' => 'Surat Jalan'
//                 ]);
//             default:
//                 return view('admin.pages.sedot-tinja.surat-perintah-kerja', [
//                     'item' => $sedotTinja,
//                     'page_title' => 'Surat Perintah Kerja'
//                 ]);
//         }
//     }
}