<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PPIDPelaksanaKategori;

class PPIDPelaksanaKategoriController extends Controller
{
    public function index()
    {
        $page_title = "Kategori PPID Pelaksana";
        $kategori = PPIDPelaksanaKategori::all();

        return view('admin.pages.ppid-pelaksana.kategori.index', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }
}
