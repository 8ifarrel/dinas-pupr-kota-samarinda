<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaKategori;

class BeritaAdminController extends Controller
{
    /**
     * TODOO:
     * 1. Fitur edit
     * 2. Fitur delete
     * 3. User hanya bisa mengakses berita berdasarkan jabatan yang dimiliki (khusus untuk IT PUPR bisa mengakses semua berita)
     */
    public function index($id)
    {
        $kategori = BeritaKategori::findOrFail($id);
        $berita = Berita::where('id_berita_kategori', $id)->get();
        $page_title = "Berita dari " . $kategori->jabatan->nama_jabatan;

        return view('admin.pages.berita.index', [
            'page_title' => $page_title,
            'berita' => $berita,
        ]);
    }
}
