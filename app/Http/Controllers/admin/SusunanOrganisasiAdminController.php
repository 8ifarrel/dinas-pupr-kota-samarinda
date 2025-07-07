<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasiDiagram;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\StrukturOrganisasiSlider;

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

    // Cek subbagian/fungsional
    $isSubbagian = $request->has('is_subbagian');
    $isFungsional = $request->has('is_jabatan_fungsional');

    // Set id_susunan_organisasi_parent sesuai ketentuan
    if ($isSubbagian) {
      $data['id_susunan_organisasi_parent'] = $request->input('subbagian_parent');
    } elseif ($isFungsional) {
      $data['id_susunan_organisasi_parent'] = $request->input('fungsional_parent');
    } else {
      $data['id_susunan_organisasi_parent'] = 1;
    }

    $susunan = SusunanOrganisasi::create($data);

    // Jika subbagian/fungsional, skip struktur_organisasi, diagram, slider
    if ($isSubbagian || $isFungsional) {
      return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Susunan Organisasi berhasil ditambahkan.');
    }

    // --- Handle Struktur Organisasi ---
    $maxUrut = StrukturOrganisasi::max('nomor_urut_jabatan');
    $nextUrut = $maxUrut ? $maxUrut + 1 : 1;
    $struktur = StrukturOrganisasi::create([
      'id_susunan_organisasi' => $susunan->id_susunan_organisasi,
      'nomor_urut_jabatan' => $nextUrut,
    ]);

    $slug = $susunan->slug_susunan_organisasi;

    // --- Handle Ikon Jabatan ---
    if ($request->hasFile('ikon_jabatan')) {
      $ikonFile = $request->file('ikon_jabatan');
      $ikonExt = $ikonFile->getClientOriginalExtension();
      $ikonPath = "struktur-organisasi/{$slug}/ikon/{$slug}.{$ikonExt}";
      $ikonFile->storeAs("public/struktur-organisasi/{$slug}/ikon", "{$slug}.{$ikonExt}");
      // Simpan path hanya ke struktur_organisasi (bukan ke susunan_organisasi)
      $struktur->ikon_jabatan = $ikonPath;
      $struktur->save();
      // Hapus baris berikut agar tidak update kolom yang tidak ada:
      // $susunan->ikon_jabatan = $ikonPath;
      // $susunan->save();
    }

    // --- Handle Organigram ---
    if ($request->hasFile('foto_organigram')) {
      $fotoFile = $request->file('foto_organigram');
      $fotoExt = $fotoFile->getClientOriginalExtension();
      $organigramPath = "struktur-organisasi/{$slug}/diagram/{$slug}.{$fotoExt}";
      $fotoFile->storeAs("public/struktur-organisasi/{$slug}/diagram", "{$slug}.{$fotoExt}");

      $diagram = new StrukturOrganisasiDiagram();
      $diagram->id_struktur_organisasi = $struktur->id_struktur_organisasi;
      $diagram->diagram_struktur_organisasi = $organigramPath;
      $diagram->save();
    }

    if ($request->hasFile('slider_jabatan')) {
      $sliderFiles = $request->file('slider_jabatan');
      $i = 1;
      foreach ($sliderFiles as $sliderFile) {
        if (!$sliderFile || !$sliderFile->isValid())
          continue;
        $sliderExt = $sliderFile->getClientOriginalExtension();
        $sliderPath = "struktur-organisasi/{$slug}/slider/{$slug}-{$i}.{$sliderExt}";
        $sliderFile->storeAs("public/struktur-organisasi/{$slug}/slider", "{$slug}-{$i}.{$sliderExt}");

        StrukturOrganisasiSlider::create([
          'id_struktur_organisasi' => $struktur->id_struktur_organisasi,
          'foto' => $sliderPath,
          'keterangan' => null,
        ]);
        $i++;
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

    $isSubbagian = $request->has('is_subbagian');
    $isFungsional = $request->has('is_jabatan_fungsional');

    // Set id_susunan_organisasi_parent sesuai ketentuan
    if ($isSubbagian) {
      $data['id_susunan_organisasi_parent'] = $request->input('subbagian_parent');
    } elseif ($isFungsional) {
      $data['id_susunan_organisasi_parent'] = $request->input('fungsional_parent');
    } else {
      $data['id_susunan_organisasi_parent'] = 1;
    }

    $susunan->update($data);

    // Jika subbagian/fungsional, hapus struktur_organisasi, diagram, slider jika ada
    if ($isSubbagian || $isFungsional) {
      if ($susunan->strukturOrganisasi) {
        // Hapus ikon
        if ($susunan->strukturOrganisasi->ikon_jabatan && Storage::disk('public')->exists($susunan->strukturOrganisasi->ikon_jabatan)) {
          Storage::disk('public')->delete($susunan->strukturOrganisasi->ikon_jabatan);
        }
        // Hapus diagram
        $diagram = $susunan->strukturOrganisasi->strukturOrganisasiDiagram;
        if ($diagram && $diagram->diagram_struktur_organisasi && Storage::disk('public')->exists($diagram->diagram_struktur_organisasi)) {
          Storage::disk('public')->delete($diagram->diagram_struktur_organisasi);
        }
        if ($diagram)
          $diagram->delete();
        // Hapus slider
        foreach ($susunan->strukturOrganisasi->slider as $slider) {
          if ($slider->foto && Storage::disk('public')->exists($slider->foto)) {
            Storage::disk('public')->delete($slider->foto);
          }
          $slider->delete();
        }
        // Hapus struktur_organisasi
        $susunan->strukturOrganisasi->delete();
      }
      return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Susunan Organisasi berhasil diperbarui.');
    }

    // --- Handle Struktur Organisasi ---
    $struktur = $susunan->strukturOrganisasi;
    if (!$struktur) {
      $maxUrut = StrukturOrganisasi::max('nomor_urut_jabatan');
      $nextUrut = $maxUrut ? $maxUrut + 1 : 1;
      $struktur = StrukturOrganisasi::create([
        'id_susunan_organisasi' => $susunan->id_susunan_organisasi,
        'nomor_urut_jabatan' => $nextUrut,
      ]);
    }

    $slug = $susunan->slug_susunan_organisasi;

    // --- Handle Ikon Jabatan ---
    if ($request->hasFile('ikon_jabatan')) {
      // Hapus ikon lama jika ada
      if ($struktur->ikon_jabatan && Storage::disk('public')->exists($struktur->ikon_jabatan)) {
        Storage::disk('public')->delete($struktur->ikon_jabatan);
      }
      $ikonFile = $request->file('ikon_jabatan');
      $ikonExt = $ikonFile->getClientOriginalExtension();
      $ikonPath = "struktur-organisasi/{$slug}/ikon/{$slug}.{$ikonExt}";
      $ikonFile->storeAs("public/struktur-organisasi/{$slug}/ikon", "{$slug}.{$ikonExt}");
      $struktur->ikon_jabatan = $ikonPath;
      $struktur->save();
    }

    // --- Handle Organigram ---
    if ($request->hasFile('foto_organigram')) {
      $diagram = $struktur->strukturOrganisasiDiagram;
      // Hapus diagram lama jika ada
      if ($diagram && $diagram->diagram_struktur_organisasi && Storage::disk('public')->exists($diagram->diagram_struktur_organisasi)) {
        Storage::disk('public')->delete($diagram->diagram_struktur_organisasi);
      }
      $fotoFile = $request->file('foto_organigram');
      $fotoExt = $fotoFile->getClientOriginalExtension();
      $organigramPath = "struktur-organisasi/{$slug}/diagram/{$slug}.{$fotoExt}";
      $fotoFile->storeAs("public/struktur-organisasi/{$slug}/diagram", "{$slug}.{$fotoExt}");
      if (!$diagram) {
        $diagram = new StrukturOrganisasiDiagram();
        $diagram->id_struktur_organisasi = $struktur->id_struktur_organisasi;
      }
      $diagram->diagram_struktur_organisasi = $organigramPath;
      $diagram->save();
    }

    // --- Handle Slider (multiple) ---
    // 1. Hapus slider yang dihapus user (tombol x)
    $hapusSliderIds = $request->input('hapus_slider', []);
    if (!empty($hapusSliderIds) && is_array($hapusSliderIds)) {
      foreach ($hapusSliderIds as $idSlider) {
        $slider = $struktur->slider()->where('id_slider', $idSlider)->first();
        if ($slider) {
          if ($slider->foto && Storage::disk('public')->exists($slider->foto)) {
            Storage::disk('public')->delete($slider->foto);
          }
          $slider->delete();
        }
      }
    }
    // 2. Tambahkan slider baru tanpa menghapus slider lama yang tidak dihapus
    if ($request->hasFile('slider_jabatan')) {
      $sliderFiles = $request->file('slider_jabatan');
      $i = 1;
      foreach ($sliderFiles as $sliderFile) {
        if (!$sliderFile || !$sliderFile->isValid())
          continue;
        $sliderExt = $sliderFile->getClientOriginalExtension();
        $sliderPath = "struktur-organisasi/{$slug}/slider/{$slug}-" . uniqid() . "-{$i}.{$sliderExt}";
        $sliderFile->storeAs("public/struktur-organisasi/{$slug}/slider", basename($sliderPath));
        StrukturOrganisasiSlider::create([
          'id_struktur_organisasi' => $struktur->id_struktur_organisasi,
          'foto' => $sliderPath,
          'keterangan' => null,
        ]);
        $i++;
      }
    }

    return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Organisasi berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $susunan = SusunanOrganisasi::findOrFail($id);
    $susunan->delete();

    return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Organisasi berhasil dihapus.');
  }
}