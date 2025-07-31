<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\APIKey;

class APIKeySuperAdminController extends Controller
{
    /**
     * Menampilkan data API key yang ada di sistem.
     */
    public function index()
    {
        $page_title = "API Key";
        $page_description = "Kelola API Key yang digunakan untuk mengakses API dari sistem ini.";
        // TODO: Panggil data API Key dari model
        // $api_key = 

        return view('admin.pages.super-admin.api-key.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            // TODO: Uncomment ini
            // 'api_key' => $api_key
        ]);
    }

    /**
     * Menampilkan form untuk membuat API key.
     */
    public function create()
    {
        $page_title = "Buat API Key";
        $page_description = "Tambah API Key baru untuk mengakses API dari sistem ini.";

        return view('admin.pages.super-admin.api-key.create', [
            'page_title' => $page_title,
            'page_description' => $page_description,
        ]);
    }

    /**
     * Memperbarui status API
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        // TODO: Validasi data yang dikirim dari form
        // TODO: Update data API berdasarkan ID
        // TODO: Redirect atau berikan response setelah update
    }

    /**
     * Menghapus data API dari database berdasarkan ID.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        // TODO: Validasi data yang dikirim dari form
        // TODO: Hapus data API berdasarkan ID
        // TODO: Redirect atau berikan response setelah penghapusan
    }
}
