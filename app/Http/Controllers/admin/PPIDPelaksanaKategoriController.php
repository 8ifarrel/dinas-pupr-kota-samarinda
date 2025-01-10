<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PPIDPelaksanaKategori;
use Illuminate\Support\Str;

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

    public function create()
    {
        $page_title = "Tambah Kategori PPID Pelaksana";

        return view('admin.pages.ppid-pelaksana.kategori.create', [
            'page_title' => $page_title,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->nama);

        PPIDPelaksanaKategori::create([
            'nama' => $request->nama,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.ppid-pelaksana.kategori.index')->with('success', 'Kategori PPID Pelaksana berhasil ditambahkan.');
    }

    /**
     * TODO:
     * 1. Tambahkan code untuk sekaligus menghapus data yang terikat dengan kategori
     */
    public function destroy($id)
    {
        $kategori = PPIDPelaksanaKategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.ppid-pelaksana.kategori.index')->with('success', 'Kategori PPID Pelaksana berhasil dihapus.');
    }
}
