<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlbumKegiatan;
use App\Models\FotoKegiatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FotoKegiatanAdminController extends Controller
{
  public function create($albumId)
  {


    $album = AlbumKegiatan::findOrFail($albumId);
    $judul_album = $album->judul;
    $page_title = "Tambah Foto Kegiatan";
    $page_description = "Unggah foto baru ke album kegiatan {$judul_album}.";
    return view('admin.pages.album-kegiatan.foto-kegiatan.create', [
      'album' => $album,
      'page_title' => $page_title,
      'page_description' => $page_description,
    ]);
  }

  public function store(Request $request, $albumId)
  {
    $album = AlbumKegiatan::findOrFail($albumId);
    $request->validate([
        'foto' => 'required|array|min:1',
        'foto.*' => 'required|file|image|max:2048',
        'caption' => 'nullable|array',
        'caption.*' => 'nullable|string|max:255',
    ]);

    foreach ($request->file('foto') as $idx => $file) {
        if (!$file || !$file->isValid())
            continue;
        $foto = new FotoKegiatan([
            'caption' => $request->caption[$idx] ?? null,
            'id_album_kegiatan' => $album->id,
        ]);
        $foto->foto = '';
        $foto->save();
        $ext = $file->getClientOriginalExtension();
        $fotoPath = "album-kegiatan/{$album->slug}/{$foto->id}.{$ext}";
        $file->storeAs("public/album-kegiatan/{$album->slug}", "{$foto->id}.{$ext}");
        $foto->foto = $fotoPath;
        $foto->save();
    }

    $album->touch();

    return redirect()->route('admin.album-kegiatan.show', $album->id)->with('success', 'Foto berhasil ditambahkan.');
  }

  public function edit($albumId, $fotoId)
  {
    $page_title = "Edit Foto Kegiatan";
    $page_description = "Perbarui informasi foto kegiatan di album.";
    $album = AlbumKegiatan::findOrFail($albumId);
    $foto = FotoKegiatan::findOrFail($fotoId);
    return view('admin.pages.album-kegiatan.foto-kegiatan.edit', [
      'album' => $album,
      'foto' => $foto,
      'page_title' => $page_title,
      'page_description' => $page_description,
    ]);
  }

  public function update(Request $request, $albumId, $fotoId)
  {
    $foto = FotoKegiatan::findOrFail($fotoId);
    $request->validate([
        'caption' => 'nullable|string|max:255',
        'foto' => 'nullable|file|image|max:2048',
    ]);
    $foto->caption = $request->caption;
    if ($request->hasFile('foto')) {
        // Hapus lama
        if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
            Storage::disk('public')->delete($foto->foto);
        }
        $album = AlbumKegiatan::findOrFail($albumId);
        $ext = $request->file('foto')->getClientOriginalExtension();
        $fotoPath = "album-kegiatan/{$album->slug}/{$foto->id}.{$ext}";
        $request->file('foto')->storeAs("public/album-kegiatan/{$album->slug}", "{$foto->id}.{$ext}");
        $foto->foto = $fotoPath;
    }
    $foto->save();

    // Update updated_at album
    $foto->albumKegiatan->touch();

    return redirect()->route('admin.album-kegiatan.show', $albumId)->with('success', 'Foto berhasil diperbarui.');
  }

  public function destroy($albumId, $fotoId)
  {
    $foto = FotoKegiatan::findOrFail($fotoId);
    $album = $foto->albumKegiatan;
    if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
        Storage::disk('public')->delete($foto->foto);
    }
    $foto->delete();

    // Update updated_at album
    if ($album) $album->touch();

    return redirect()->route('admin.album-kegiatan.show', $albumId)->with('success', 'Foto berhasil dihapus.');
  }
}
