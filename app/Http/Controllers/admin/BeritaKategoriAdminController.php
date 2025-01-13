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

        /**
         * Fitur agar user hanya bisa mengakses kategori berita berdasarkan jabatan yang dimiliki.
         * Fitur ini belum dicoba karena user masih sedikit.
         */
        $user = Auth::user();
        $jabatan = $user->pegawai->jabatan;
        
        if ($jabatan->id_jabatan == 0 || $jabatan->id_jabatan == 1) {
            $kategori = BeritaKategori::all();
        } else {
            $jabatanId = strpos($jabatan->kelompok_jabatan, 'Subbagian') !== false 
                ? $jabatan->id_jabatan_parent 
                : $jabatan->id_jabatan;
        
            $kategori = BeritaKategori::whereHas('jabatan', function ($query) use ($jabatanId) {
                $query->where('id_jabatan', $jabatanId);
            })->get();
        }
        

        return view('admin.pages.berita.kategori.index', [
            'page_title' => $page_title,
            'kategori' => $kategori,
        ]);
    }

    public function edit($id)
    {
        $page_title = "Edit Kategori Berita";
        $kategori = BeritaKategori::findOrFail($id);

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

        $kategori = BeritaKategori::findOrFail($id);

        if ($request->has('ikon_berita_kategori')) {
            $ikonKategoriData = json_decode($request->input('ikon_berita_kategori'), true);
            if (isset($ikonKategoriData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $ikonKategoriData['fileUrl']);
                $newFileName = 'Berita/ikon/' . $kategori->jabatan->slug_jabatan . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $kategori->ikon_berita_kategori = $newFileName;
            }
        }

        $kategori->save();

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori Berita berhasil diperbarui.');
    }
}
