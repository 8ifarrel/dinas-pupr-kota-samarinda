<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasiDiagram;
use App\Support\Shared\UploadGambar;

class OrganigramAdminController extends Controller
{
  public function index()
  {
    $page_title = "Organigram";
    $page_description = 'Bagan organigram utama Dinas PUPR Kota Samarinda.';
    $organigram = StrukturOrganisasiDiagram::select('diagram_struktur_organisasi')
      ->whereNull('id_struktur_organisasi')
      ->first();

    return view('admin.pages.struktur-organisasi.organigram.index', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'organigram' => $organigram,
    ]);
  }

  public function edit($id)
  {
    if ($id != 1) {
      abort(404);
    }
    $organigram = StrukturOrganisasiDiagram::findOrFail($id);
    $page_title = "Edit Organigram";
    $page_description = "Ganti foto untuk mengubah organigram.";

    return view('admin.pages.struktur-organisasi.organigram.edit', [
      'page_title' => $page_title,
      'organigram' => $organigram,
      'page_description' => $page_description,
    ]);
  }

  public function update(Request $request, $id)
  {
    if ($id != 1) {
      abort(404);
    }
    $request->validate([
      'foto_organigram' => 'required|string',
    ]);

    $organigram = StrukturOrganisasiDiagram::findOrFail($id);

    $tujuan = 'Organigram/' . now()->format('Y-m') . '/' . now()->format('d') . '/organigram';
    $baru = UploadGambar::simpan($request, 'foto_organigram', $tujuan, $organigram->diagram_struktur_organisasi);
    if ($baru !== null) {
      $organigram->diagram_struktur_organisasi = $baru;
      $organigram->save();
    }

    return redirect()->route('admin.struktur-organisasi.organigram.index')->with('success', 'Organigram berhasil diperbarui.');
  }
}

