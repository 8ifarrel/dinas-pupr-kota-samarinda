<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasiDiagram;
use Illuminate\Support\Facades\Storage;

class OrganigramAdminController extends Controller
{
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

    $fotoData = json_decode($request->input('foto_organigram'), true);
    if (isset($fotoData['fileUrl'])) {
      $tempFilePath = str_replace('/storage/', '', $fotoData['fileUrl']);
      $newFileName = 'Organigram/' . now()->format('Y-m') . '/' . now()->format('d') . '/organigram.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);

      // Hapus file lama jika ada
      if ($organigram->diagram_struktur_organisasi && Storage::disk('public')->exists($organigram->diagram_struktur_organisasi)) {
        Storage::disk('public')->delete($organigram->diagram_struktur_organisasi);
      }

      Storage::disk('public')->move($tempFilePath, $newFileName);
      $organigram->diagram_struktur_organisasi = $newFileName;
      $organigram->save();
    }

    return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Organigram berhasil diperbarui.');
  }
}

