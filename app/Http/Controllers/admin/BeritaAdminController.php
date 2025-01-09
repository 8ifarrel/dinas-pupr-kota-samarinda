<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaKategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaAdminController extends Controller
{
    /**
     * TODOO:
     * 1. Fitur edit
     * 2. Fitur delete
     * 3. User hanya bisa mengakses berita berdasarkan jabatan yang dimiliki (khusus untuk IT PUPR bisa mengakses semua berita)
     */
    public function index(Request $request)
    {
        $id = $request->query('id_kategori');
        $kategori = BeritaKategori::findOrFail($id);
        $berita = Berita::where('id_berita_kategori', $id)->get();
        $page_title = "Berita dari " . $kategori->jabatan->nama_jabatan;

        return view('admin.pages.berita.index', [
            'page_title' => $page_title,
            'berita' => $berita,
        ]);
    }

    public function create(Request $request)
    {
        $id = $request->query('id_kategori');
        $kategori = BeritaKategori::findOrFail($id);
        $page_title = "Tambah Berita untuk " . $kategori->jabatan->nama_jabatan;

        return view('admin.pages.berita.create', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255|unique:berita',
            'id_berita_kategori' => 'required|exists:berita_kategori,id_berita_kategori',
            'foto_berita' => 'required|string',
            'isi_berita' => 'required|string',
            'preview_berita' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->judul_berita);

        $fotoBeritaData = json_decode($request->input('foto_berita'), true);
        if (isset($fotoBeritaData['fileUrl'])) {
            $tempFilePath = str_replace('/storage/', '', $fotoBeritaData['fileUrl']);
            $newFileName = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . Str::uuid() . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
            Storage::disk('public')->move($tempFilePath, $newFileName);
        }

        Berita::create([
            'judul_berita' => $request->judul_berita,
            'slug_berita' => $slug,
            'id_berita_kategori' => $request->id_berita_kategori,
            'foto_berita' => $newFileName,
            'sumber_foto_berita' => $request->sumber_foto_berita,
            'isi_berita' => $request->isi_berita,
            'preview_berita' => $request->preview_berita,
            'views_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.berita.index', ['id_kategori' => $request->id_berita_kategori])
            ->with('success', 'Berita berhasil ditambahkan.');
    }
}
