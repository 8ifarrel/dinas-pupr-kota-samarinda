<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeritaKategori;
use App\Support\Shared\UploadGambar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaKategoriAdminController extends Controller
{
  public function index()
  {
    $page_title = "Kategori Berita";
    $page_description = "Kelola kategori yang mengelompokkan berita. Kategori mengikuti struktur organisasi yang ada.";

    // Anotasi diperlukan karena guard mengembalikan kontrak Authenticatable,
    // sedangkan model sebenarnya baru ditentukan config/auth.php saat berjalan.
    /** @var \App\Models\User|null $user */
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

    $slug = $kategori->susunanOrganisasi->slug_susunan_organisasi ?? Str::slug($kategori->nama_kategori ?? 'kategori');
    $baru = UploadGambar::simpan($request, 'ikon_berita_kategori', "Berita/ikon/{$slug}", $kategori->ikon_berita_kategori);
    if ($baru !== null) {
      $kategori->ikon_berita_kategori = $baru;
    }

    $kategori->save();

    return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori Berita berhasil diperbarui.');
  }
}
