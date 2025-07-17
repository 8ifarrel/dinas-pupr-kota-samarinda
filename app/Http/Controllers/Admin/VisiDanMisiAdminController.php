<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visi;
use App\Models\Misi;

class VisiDanMisiAdminController extends Controller
{
  public function index()
  {
    $page_title = "Visi dan Misi";
    $page_description = "Menampilkan visi dan misi Dinas PUPR Kota Samarinda dalam periode yang telah ditentukan.";

    $visi = Visi::select(
      'deskripsi_visi',
      'periode_mulai',
      'periode_selesai'
    )->first();

    $misi = Misi::select(
      'deskripsi_misi',
      'periode_mulai',
      'periode_selesai'
    )->orderBy('nomor_urut')->get();

    return view('admin.pages.profil.visi-dan-misi.index', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'visi' => $visi,
      'misi' => $misi
    ]);
  }

  public function edit()
  {
    $page_title = "Edit Visi dan Misi";
    $page_description = "Ubah atau perbarui data visi dan misi beserta periode berlakunya.";
    $visi = Visi::first();
    $misi = Misi::orderBy('nomor_urut')->get();

    return view('admin.pages.profil.visi-dan-misi.edit', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'visi' => $visi,
      'misi' => $misi
    ]);
  }

  public function update(Request $request)
  {
    $request->validate([
      'deskripsi_visi' => 'required|string',
      'periode_mulai' => 'required|integer',
      'periode_selesai' => 'required|integer',
      'misi' => 'required|array',
      'misi.*' => 'required|string'
    ]);

    // Update visi
    $visi = Visi::first();
    if ($visi) {
      $visi->update([
        'deskripsi_visi' => $request->input('deskripsi_visi'),
        'periode_mulai' => $request->input('periode_mulai'),
        'periode_selesai' => $request->input('periode_selesai'),
      ]);
    } else {
      Visi::create([
        'deskripsi_visi' => $request->input('deskripsi_visi'),
        'periode_mulai' => $request->input('periode_mulai'),
        'periode_selesai' => $request->input('periode_selesai'),
      ]);
    }

    // Update misi
    Misi::truncate();
    foreach ($request->input('misi') as $index => $deskripsi_misi) {
      Misi::create([
        'nomor_urut' => $index + 1,
        'deskripsi_misi' => $deskripsi_misi,
        'periode_mulai' => $request->input('periode_mulai'),
        'periode_selesai' => $request->input('periode_selesai'),
      ]);
    }

    return redirect()->route('admin.profil.visi-dan-misi.index')->with('success', 'Visi dan Misi berhasil diperbarui.');
  }
}

