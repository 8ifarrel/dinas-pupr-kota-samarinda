<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeritaKategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaKategoriAdminController extends Controller
{
    public function index()
    {
        $page_title = "Kategori Berita";
        $page_description = "Kelola kategori yang mengelompokkan berita. Kategori mengikuti struktur organisasi yang ada.";

        $user = Auth::user();
        $susunanOrganisasi = $user->susunanOrganisasi ?? null;

        $id_kepala_dinas = 1;
        if (
            ($user && $user->is_super_admin) ||
            ($susunanOrganisasi && in_array($susunanOrganisasi->id_susunan_organisasi, [$id_kepala_dinas]))
        ) {
            $kategori = BeritaKategori::get();
        } else {
            $susunanOrganisasiId = $susunanOrganisasi ? $susunanOrganisasi->id_susunan_organisasi : null;
            $kategori = BeritaKategori::where('id_susunan_organisasi', $susunanOrganisasiId)->with('susunanOrganisasi')->get();
        }

        return view('admin.pages.berita.kategori.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'kategori' => $kategori,
        ]);
    }

    public function edit($id)
    {
        $page_title = "Edit Kategori Berita";
        $page_description = "Ubah ikon kategori berita yang sudah ada.";
        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($id);

        return view('admin.pages.berita.kategori.edit', [
            'page_title' => $page_title,
            'kategori' => $kategori,
            'page_description' => $page_description,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ikon_berita_kategori' => 'nullable',
        ]);

        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($id);

        // Mirip struktur organisasi: handle file biasa atau filepond/cropper (json string)
        if ($request->hasFile('ikon_berita_kategori')) {
            // Hapus lama jika ada
            if ($kategori->ikon_berita_kategori && Storage::disk('public')->exists($kategori->ikon_berita_kategori)) {
                Storage::disk('public')->delete($kategori->ikon_berita_kategori);
            }
            $file = $request->file('ikon_berita_kategori');
            $slug = $kategori->susunanOrganisasi->slug_susunan_organisasi ?? Str::slug($kategori->nama_kategori ?? 'kategori');
            $ext = $file->getClientOriginalExtension();
            $path = "Berita/ikon/{$slug}.{$ext}";
            $file->storeAs("public/Berita/ikon", "{$slug}.{$ext}");
            $kategori->ikon_berita_kategori = $path;
        } elseif ($request->filled('ikon_berita_kategori')) {
            $ikonKategoriData = json_decode($request->input('ikon_berita_kategori'), true);
            if (isset($ikonKategoriData['fileUrl'])) {
                // Hapus lama jika ada
                if ($kategori->ikon_berita_kategori && Storage::disk('public')->exists($kategori->ikon_berita_kategori)) {
                    Storage::disk('public')->delete($kategori->ikon_berita_kategori);
                }
                $tempFilePath = str_replace('/storage/', '', $ikonKategoriData['fileUrl']);
                $slug = $kategori->susunanOrganisasi->slug_susunan_organisasi ?? Str::slug($kategori->nama_kategori ?? 'kategori');
                $ext = pathinfo($tempFilePath, PATHINFO_EXTENSION);
                $path = "Berita/ikon/{$slug}.{$ext}";
                Storage::disk('public')->move($tempFilePath, $path);
                $kategori->ikon_berita_kategori = $path;
            }
        }

        $kategori->save();

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori Berita berhasil diperbarui.');
    }
}
