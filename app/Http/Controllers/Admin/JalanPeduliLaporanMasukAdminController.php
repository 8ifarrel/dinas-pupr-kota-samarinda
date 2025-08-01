<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JalanPeduliLaporanMasukAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index()
    {
        $page_title = "Jalan Peduli - Laporan Masuk";
        $page_description = "Verifikasi, lihat, atau unduh laporan yang masuk. Laporan yang telah disetujui dapat ditindaklanjuti pada halaman Tindaklanjuti Laporan.";
        // TODO: Panggil data jalan peduli dari model

        return view('admin.pages.jalan-peduli.laporan-masuk.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            // TODO: kirim data jalan peduli ke view
        ]);
    }

    /**
     * Menampilkan detail laporan masuk berdasarkan ID.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $page_title = "Jalan Peduli - Detail Laporan";
        $page_description = "Detail laporan masuk dengan ID $id";
        // TODO: Validasi apakah laporan dengan ID tersebut ada dalam database
        // TODO: Ambil data laporan Jalan Peduli berdasarkan ID dari model


        return view('admin.pages.jalan-peduli.laporan-masuk.show', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            // TODO: kirim data jalan peduli ke view
        ]);
    }

    /**
     * Memperbarui status laporan
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        // TODO: Validasi data yang dikirim dari form
        // TODO: Update data laporan berdasarkan ID
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
