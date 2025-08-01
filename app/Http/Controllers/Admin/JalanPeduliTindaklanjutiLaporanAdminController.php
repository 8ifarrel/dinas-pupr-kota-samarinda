<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JalanPeduliTindaklanjutiLaporanAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index()
    {
        $page_title = "Jalan Peduli - Tindaklanjuti Laporan";
        $page_description = "Tindaklanjuti laporan masuk yang telah disetujui untuk mencatat perkembangan penanganan jalan rusak";
        // TODO: Panggil data jalan peduli dari model

        return view('admin.pages.jalan-peduli.tindaklanjuti-laporan.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            // TODO: kirim data jalan peduli ke view
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

        // TODO: Cari data Jalan Peduli berdasarkan ID
        // TODO: Tampilkan form dengan data yang ingin diedit

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
}
