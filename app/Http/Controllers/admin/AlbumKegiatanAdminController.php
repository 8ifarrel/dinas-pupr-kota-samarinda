<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlbumKegiatan;
use App\Models\FotoKegiatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumKegiatanAdminController extends Controller
{
    public function index()
    {
        $page_title = "Album Kegiatan";
        $page_description = "Kelola album yang berisikan foto-foto kegiatan Dinas PUPR Kota Samarinda";
        $album_kegiatan = AlbumKegiatan::with([
            'fotoKegiatan' => function ($q) {
                $q->orderBy('created_at', 'asc');
            }
        ])->get();

        return view('admin.pages.album-kegiatan.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'album_kegiatan' => $album_kegiatan,
        ]);
    }

    public function create()
    {
        $page_title = "Tambah Album Kegiatan";
        $page_description = "Buat album kegiatan dan tambahkan foto-foto kegiatan sekaligus.";
        return view('admin.pages.album-kegiatan.create', [
            'page_title' => $page_title,
            'page_description' => $page_description,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255|unique:album_kegiatan',
            'foto_kegiatan' => 'required|array|min:1',
            'foto_kegiatan.*' => 'required|file|image|max:2048',
            'caption_kegiatan' => 'nullable|array',
            'caption_kegiatan.*' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($request->judul);
        $album = AlbumKegiatan::create([
            'judul' => $request->judul,
            'slug' => $slug,
            'views_count' => 0,
        ]);

        // Perbaikan: Insert foto_kegiatan setelah path didapat
        if ($request->hasFile('foto_kegiatan')) {
            foreach ($request->file('foto_kegiatan') as $idx => $file) {
                if (!$file || !$file->isValid())
                    continue;
                $ext = $file->getClientOriginalExtension();
                // Buat dummy instance untuk dapatkan id setelah insert
                $foto = new FotoKegiatan([
                    'caption' => $request->caption_kegiatan[$idx] ?? null,
                    'id_album_kegiatan' => $album->id,
                ]);
                // Simpan dulu agar dapat id
                $foto->foto = ''; // isi sementara agar lolos validasi NOT NULL
                $foto->save();
                $fotoPath = "album-kegiatan/{$slug}/{$foto->id}.{$ext}";
                $file->storeAs("public/album-kegiatan/{$slug}", "{$foto->id}.{$ext}");
                // Update field foto
                $foto->foto = $fotoPath;
                $foto->save();
            }
        }

        return redirect()->route('admin.album-kegiatan.index')->with('success', 'Album Kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $album = AlbumKegiatan::findOrFail($id);
        $page_title = "Edit Album Kegiatan";
        $page_description = "Ubah judul album kegiatan. Untuk mengedit foto, silakan buka halaman album kegiatan yang bersangkutan.";
        return view('admin.pages.album-kegiatan.edit', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'album' => $album,
        ]);
    }

    public function update(Request $request, $id)
    {
        $album = AlbumKegiatan::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255|unique:album_kegiatan,judul,' . $id . ',id',
        ]);
        $album->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
        ]);
        return redirect()->route('admin.album-kegiatan.index')->with('success', 'Album Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $album = AlbumKegiatan::with('fotoKegiatan')->findOrFail($id);
        // Delete all photos
        foreach ($album->fotoKegiatan as $foto) {
            if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
                Storage::disk('public')->delete($foto->foto);
            }
            $foto->delete();
        }
        $album->delete();
        return redirect()->route('admin.album-kegiatan.index')->with('success', 'Album Kegiatan berhasil dihapus.');
    }

    public function show($albumId)
    {
        $album = AlbumKegiatan::with('fotoKegiatan')->findOrFail($albumId);
        $page_title = "Album Kegiatan " . $album->judul;
        $page_description = "Kelola foto yang ada di dalam album kegiatan.";

        return view('admin.pages.album-kegiatan.show', [
            'album' => $album,
            'page_title' => $page_title,
            'page_description' => $page_description,
        ]);
    }
}

