<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeritaKategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BeritaKategoriAdminController extends Controller
{
    public function index()
    {
        $page_title = "Kategori Berita";

        $user = Auth::user();
        $susunanOrganisasi = $user->susunanOrganisasi ?? null;

        $id_it_pupr = 0;
        $id_kepala_dinas = 1;
        $id_sekretariat = 2;

        if ($susunanOrganisasi && in_array($susunanOrganisasi->id_susunan_organisasi, [$id_it_pupr, $id_kepala_dinas, $id_sekretariat])) {
            $kategori = BeritaKategori::get();
        } else {
            $susunanOrganisasiId = $susunanOrganisasi ? $susunanOrganisasi->id_susunan_organisasi : null;
            $kategori = BeritaKategori::where('id_susunan_organisasi', $susunanOrganisasiId)->with('susunanOrganisasi')->get();
        }

        return view('admin.pages.berita.kategori.index', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    public function edit($id)
    {
        $page_title = "Edit Kategori Berita";
        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($id);

        return view('admin.pages.berita.kategori.edit', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ikon_berita_kategori' => 'nullable|string',
        ]);

        $kategori = BeritaKategori::with('susunanOrganisasi')->findOrFail($id);

        if ($request->has('ikon_berita_kategori')) {
            $ikonKategoriData = json_decode($request->input('ikon_berita_kategori'), true);
            if (isset($ikonKategoriData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $ikonKategoriData['fileUrl']);
                $slug = $kategori->susunanOrganisasi->slug_susunan_organisasi ?? 'kategori';
                $newFileName = 'Berita/ikon/' . $slug . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $kategori->ikon_berita_kategori = $newFileName;
            }
        }

        $kategori->save();

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori Berita berhasil diperbarui.');
    }
}