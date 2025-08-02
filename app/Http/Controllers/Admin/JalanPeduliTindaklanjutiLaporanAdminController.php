<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JalanPeduliLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JalanPeduliTindaklanjutiLaporanAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index(Request $request)
    {
        $page_title = "Jalan Peduli - Tindaklanjuti Laporan";
        $page_description = "Tindaklanjuti laporan masuk yang telah disetujui untuk mencatat perkembangan penanganan jalan rusak";

        $query = JalanPeduliLaporan::with(['status', 'kecamatan', 'kelurahan']);

        $excludeStatus = ['pending', 'reject'];
        $query->whereHas('status', function ($q) use ($excludeStatus) {
            $q->whereNotIn('nama_status', $excludeStatus);
        });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id_laporan', 'like', "%{$search}%")
                    ->orWhere('nomor_ponsel', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tingkat_kerusakan_filter')) {
            $query->where('tingkat_kerusakan', $request->input('tingkat_kerusakan_filter'));
        }
        if ($request->filled('jenis_kerusakan_filter')) {
            $query->where('jenis_kerusakan', $request->input('jenis_kerusakan_filter'));
        }
        if ($request->filled('status_kerusakan_filter')) {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('nama_status', $request->input('status_kerusakan_filter'));
            });
        }

        // Jika request map=1, return JSON untuk peta
        if ($request->has('map')) {
            $laporans = $query->get();
            return response()->json($laporans);
        }

        $laporans = $query->orderByDesc('created_at')->paginate(12);

        return view('admin.pages.jalan-peduli.tindaklanjuti-laporan.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'laporans' => $laporans,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit data Jalan Peduli berdasarkan ID.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $page_title = "Jalan Peduli - Edit Laporan";
        $page_description = "Catat perkembangan penanganan laporan masuk dengan ID $id";

        // TODO: Validasi apakah laporan dengan ID tersebut ada dalam database
        // TODO: Ambil data laporan Jalan Peduli berdasarkan ID dari model

        return view('admin.pages.jalan-peduli.tindaklanjuti-laporan.edit', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            // TODO: kirim data jalan peduli ke view
        ]);
    }

    /**
     * Memperbarui data Jalan Peduli berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        // TODO: Validasi data yang dikirim dari form
        // TODO: Update data Jalan Peduli berdasarkan ID
        // TODO: Redirect atau berikan response setelah update
    }

    /**
     * Menghapus data laporan dari database berdasarkan ID.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        // TODO: Validasi data yang dikirim dari form
        // TODO: Hapus data laporan berdasarkan ID
        // TODO: Redirect atau berikan response setelah penghapusan
    }
}

