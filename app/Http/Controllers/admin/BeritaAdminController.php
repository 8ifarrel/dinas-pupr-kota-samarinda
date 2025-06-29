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
    public function index(Request $request)
    {
        $id = $request->query('id_kategori');
        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($id);
        $berita = Berita::where('id_berita_kategori', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->formatted_created_at = $item->created_at->translatedFormat('l, d F Y');
                return $item;
            });
        $page_title = "Berita dari " . ($kategori->susunanOrganisasi->nama_susunan_organisasi ?? '-');

        return view('admin.pages.berita.index', [
            'page_title' => $page_title,
            'berita' => $berita,
        ]);
    }

    public function create(Request $request)
    {
        $id = $request->query('id_kategori');
        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($id);
        $page_title = "Tambah Berita untuk " . ($kategori->susunanOrganisasi->nama_susunan_organisasi ?? '-');

        return view('admin.pages.berita.create', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    /**
     * WARN:
     * 1. UUID berita tidak sesuai dengan nama file foto berita, padahal code sudah disesuaikan
     */
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
        $uuid = Str::uuid();

        $fotoBeritaData = json_decode($request->input('foto_berita'), true);
        if (isset($fotoBeritaData['fileUrl'])) {
            $tempFilePath = str_replace('/storage/', '', $fotoBeritaData['fileUrl']);
            $newFileName = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . $uuid . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
            Storage::disk('public')->move($tempFilePath, $newFileName);
        }

        Berita::create([
            'uuid_berita' => $uuid,
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

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($berita->id_berita_kategori);
        $page_title = "Edit Berita";

        return view('admin.pages.berita.edit', [
            'page_title' => $page_title,
            'berita' => $berita,
            'kategori' => $kategori,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255|unique:berita,judul_berita,' . $id . ',uuid_berita',
            'id_berita_kategori' => 'required|exists:berita_kategori,id_berita_kategori',
            'foto_berita' => 'nullable|string',
            'isi_berita' => 'required|string',
            'preview_berita' => 'required|string|max:255',
        ]);

        $berita = Berita::findOrFail($id);
        $slug = Str::slug($request->judul_berita);

        if ($request->has('foto_berita')) {
            $fotoBeritaData = json_decode($request->input('foto_berita'), true);
            if (isset($fotoBeritaData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoBeritaData['fileUrl']);
                $newFileName = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . $id . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $berita->foto_berita = $newFileName;
            }
        }

        $berita->update([
            'judul_berita' => $request->judul_berita,
            'slug_berita' => $slug,
            'id_berita_kategori' => $request->id_berita_kategori,
            'sumber_foto_berita' => $request->sumber_foto_berita,
            'isi_berita' => $request->isi_berita,
            'preview_berita' => $request->preview_berita,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.berita.index', ['id_kategori' => $request->id_berita_kategori])
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if (Storage::disk('public')->exists($berita->foto_berita)) {
            Storage::disk('public')->delete($berita->foto_berita);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index', ['id_kategori' => $berita->id_berita_kategori])
            ->with('success', 'Berita berhasil dihapus.');
    }
}
