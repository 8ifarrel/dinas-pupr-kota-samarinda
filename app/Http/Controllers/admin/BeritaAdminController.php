<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeritaKategori;

class BeritaAdminController extends Controller
{
    /**
     * NOTE(S):
     * 1. Kategori harus punya controller sendiri
     */

    public function indexKategori()
    {
        $page_title = "Kategori Berita";
        $kategori = BeritaKategori::all();

        return view('admin.pages.berita.kategori.index', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    public function editKategori($id)
    {
        $page_title = "Edit Kategori Berita";
        $kategori = BeritaKategori::findOrFail($id);

        return view('admin.pages.berita.kategori.edit', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'ikon_kategori' => 'nullable|string|max:255',
        ]);

        $kategori = BeritaKategori::findOrFail($id);
        $kategori->nama_kategori = $request->input('nama_kategori');
        $kategori->ikon_kategori = $request->input('ikon_kategori');
        $kategori->save();

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori Berita berhasil diperbarui.');
    }
}
