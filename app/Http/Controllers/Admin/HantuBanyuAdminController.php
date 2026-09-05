<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HantuBanyuAdminController extends Controller
{
    /**
     * Halaman Hantu Banyu tidak punya konten sendiri, langsung arahkan
     * ke daftar laporan masuk.
     */
    public function index()
    {
        return redirect()->route('admin.hantu-banyu.laporan.index');
    }
}
