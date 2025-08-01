<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JalanPeduliStatistikLaporanAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index()
    {
        $page_title = "Jalan Peduli - Statistik Laporan";
        $page_description = "Visualisasi perkembangan laporan jalan";
        // TODO: Panggil data jalan peduli dari model

        return view('admin.pages.jalan-peduli.statistik-laporan.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            // TODO: kirim data jalan peduli ke view
        ]);
    }
}
