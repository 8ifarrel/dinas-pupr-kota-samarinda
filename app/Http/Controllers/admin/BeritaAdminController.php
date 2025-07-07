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
            'foto_berita' => 'required',
            'isi_berita' => 'required|string',
            'preview_berita' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->judul_berita);
        $uuid = Str::uuid();
        $fotoPath = null;

        // Mirip struktur organisasi: handle file biasa atau filepond/cropper (json string)
        if ($request->hasFile('foto_berita')) {
            $file = $request->file('foto_berita');
            $ext = $file->getClientOriginalExtension();
            $fotoPath = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . $uuid . '.' . $ext;
            $file->storeAs('public/Berita/' . now()->format('Y-m') . '/' . now()->format('d'), $uuid . '.' . $ext);
        } else {
            $fotoBeritaData = json_decode($request->input('foto_berita'), true);
            if (isset($fotoBeritaData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoBeritaData['fileUrl']);
                $ext = pathinfo($tempFilePath, PATHINFO_EXTENSION);
                $fotoPath = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . $uuid . '.' . $ext;
                Storage::disk('public')->move($tempFilePath, $fotoPath);
            }
        }

        Berita::create([
            'uuid_berita' => $uuid,
            'judul_berita' => $request->judul_berita,
            'slug_berita' => $slug,
            'id_berita_kategori' => $request->id_berita_kategori,
            'foto_berita' => $fotoPath,
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
            'foto_berita' => 'nullable',
            'isi_berita' => 'required|string',
            'preview_berita' => 'required|string|max:255',
        ]);

        $berita = Berita::findOrFail($id);
        $slug = Str::slug($request->judul_berita);

        // Mirip struktur organisasi: handle file biasa atau filepond/cropper (json string)
        if ($request->hasFile('foto_berita')) {
            // Hapus lama jika ada
            if ($berita->foto_berita && Storage::disk('public')->exists($berita->foto_berita)) {
                Storage::disk('public')->delete($berita->foto_berita);
            }
            $file = $request->file('foto_berita');
            $ext = $file->getClientOriginalExtension();
            $fotoPath = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . $berita->uuid_berita . '.' . $ext;
            $file->storeAs('public/Berita/' . now()->format('Y-m') . '/' . now()->format('d'), $berita->uuid_berita . '.' . $ext);
            $berita->foto_berita = $fotoPath;
        } elseif ($request->filled('foto_berita')) {
            $fotoBeritaData = json_decode($request->input('foto_berita'), true);
            if (isset($fotoBeritaData['fileUrl'])) {
                // Hapus lama jika ada
                if ($berita->foto_berita && Storage::disk('public')->exists($berita->foto_berita)) {
                    Storage::disk('public')->delete($berita->foto_berita);
                }
                $tempFilePath = str_replace('/storage/', '', $fotoBeritaData['fileUrl']);
                $ext = pathinfo($tempFilePath, PATHINFO_EXTENSION);
                $fotoPath = 'Berita/' . now()->format('Y-m') . '/' . now()->format('d') . '/' . $berita->uuid_berita . '.' . $ext;
                Storage::disk('public')->move($tempFilePath, $fotoPath);
                $berita->foto_berita = $fotoPath;
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
