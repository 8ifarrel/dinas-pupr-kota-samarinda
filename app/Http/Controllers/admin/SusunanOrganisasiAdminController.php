<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasiDiagram;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SusunanOrganisasiAdminController extends Controller
{
  public function create()
  {
    $page_title = "Tambah Susunan Organisasi";
    $susunan_organisasi_list = SusunanOrganisasi::all();

    return view('admin.pages.struktur-organisasi.susunan-organisasi.create', [
      'page_title' => $page_title,
      'susunan_organisasi_list' => $susunan_organisasi_list,
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi',
      'kelompok_susunan_organisasi' => 'required|string',
    ]);

    $data = $request->all();
    $data['slug_susunan_organisasi'] = Str::slug($request->nama_susunan_organisasi);

    $susunan = SusunanOrganisasi::create($data);

    // Validasi wajib organigram jika punya struktur organisasi
    if ($susunan && $susunan->strukturOrganisasi) {
      $request->validate([
        'foto_organigram' => 'required|string',
      ]);
    }

    // Tambahkan simpan organigram jika ada file dan susunan organisasi punya struktur organisasi
    if ($request->filled('foto_organigram') && $susunan && $susunan->strukturOrganisasi) {
      $fotoData = json_decode($request->input('foto_organigram'), true);
      if (isset($fotoData['fileUrl'])) {
        $tempFilePath = str_replace('/storage/', '', $fotoData['fileUrl']);
        $newFileName = 'Organigram/' . now()->format('Y-m') . '/' . now()->format('d') . '/organigram_' . $susunan->strukturOrganisasi->id_struktur_organisasi . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);

        Storage::disk('public')->move($tempFilePath, $newFileName);

        $diagram = $susunan->strukturOrganisasi->strukturOrganisasiDiagram;
        if (!$diagram) {
          $diagram = new StrukturOrganisasiDiagram();
          $diagram->id_struktur_organisasi = $susunan->strukturOrganisasi->id_struktur_organisasi;
        }
        $diagram->diagram_struktur_organisasi = $newFileName;
        $diagram->save();
      }
    }

    return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Organisasi berhasil ditambahkan.');
  }

  public function edit($id)
  {
    $page_title = "Edit Susunan Organisasi";
    $susunan = SusunanOrganisasi::findOrFail($id);
    $parentOptions = SusunanOrganisasi::where('id_susunan_organisasi', '!=', $id)->get();

    return view('admin.pages.struktur-organisasi.susunan-organisasi.edit', [
      'page_title' => $page_title,
      'susunan' => $susunan,
      'parentOptions' => $parentOptions,
    ]);
  }

  public function update(Request $request, $id)
  {
    $susunan = SusunanOrganisasi::findOrFail($id);

    $request->validate([
      'nama_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi,nama_susunan_organisasi,' . $id . ',id_susunan_organisasi',
      'kelompok_susunan_organisasi' => 'required|string',
    ]);

    $data = $request->all();
    $data['slug_susunan_organisasi'] = Str::slug($request->nama_susunan_organisasi);

    $susunan->update($data);

    // Hapus validasi wajib organigram pada update/edit
    // if ($susunan->strukturOrganisasi) {
    //   $request->validate([
    //     'foto_organigram' => 'required|string',
    //   ]);
    // }

    // Tambahkan update organigram jika ada file dan susunan organisasi punya struktur organisasi
    if ($request->filled('foto_organigram') && $susunan->strukturOrganisasi) {
      $fotoData = json_decode($request->input('foto_organigram'), true);
      if (isset($fotoData['fileUrl'])) {
        $tempFilePath = str_replace('/storage/', '', $fotoData['fileUrl']);
        $newFileName = 'Organigram/' . now()->format('Y-m') . '/' . now()->format('d') . '/organigram_' . $susunan->strukturOrganisasi->id_struktur_organisasi . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);

        $diagram = $susunan->strukturOrganisasi->strukturOrganisasiDiagram;
        if ($diagram && $diagram->diagram_struktur_organisasi && Storage::disk('public')->exists($diagram->diagram_struktur_organisasi)) {
          Storage::disk('public')->delete($diagram->diagram_struktur_organisasi);
        }

        Storage::disk('public')->move($tempFilePath, $newFileName);

        if (!$diagram) {
          $diagram = new StrukturOrganisasiDiagram();
          $diagram->id_struktur_organisasi = $susunan->strukturOrganisasi->id_struktur_organisasi;
        }
        $diagram->diagram_struktur_organisasi = $newFileName;
        $diagram->save();
      }
    }

    return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Organisasi berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $susunan = SusunanOrganisasi::findOrFail($id);
    $susunan->delete();

    return redirect()->route('admin.susunan-organisasi.index')->with('success', 'Struktur Organisasi berhasil dihapus.');
  }
}
