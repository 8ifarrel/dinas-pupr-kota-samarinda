<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Support\Shared\UploadGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerAdminController extends Controller
{
  public function index()
  {
    $page_title = "Partner";
    $page_description = "Kelola partner yang ditampilkan di paling bawah halaman utama.";
    $partners = Partner::all();

    return view('admin.pages.partner.index', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'partners' => $partners,
    ]);
  }

  public function create()
  {
    $page_title = "Tambah Partner";
    $page_description = "Tambah partner baru yang akan tampil di paling bawah halaman utama.";

    return view('admin.pages.partner.create', [
      'page_title' => $page_title,
      'page_description' => $page_description,
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_partner' => 'required|string|max:255',
      'url_partner' => 'required|url|max:255',
      // foto_partner bisa file atau string (filepond/cropper) atau file biasa
      'foto_partner' => 'required',
    ]);

    $partner = new Partner();
    $partner->nama_partner = $request->input('nama_partner');
    $partner->url_partner = $request->input('url_partner');

    $slug = Str::slug($request->input('nama_partner'));
    $baru = UploadGambar::simpan($request, 'foto_partner', "partner/{$slug}");
    if ($baru !== null) {
      $partner->foto_partner = $baru;
    }

    $partner->save();

    return redirect()->route('admin.partner.index')->with('success', 'Partner berhasil ditambahkan.');
  }

  public function edit($id)
  {
    $page_title = "Edit Partner";
    $page_description = "Edit partner yang sudah ditampilkan di paling bawah halaman utama.";
    $partner = Partner::findOrFail($id);

    return view('admin.pages.partner.edit', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'partner' => $partner,
    ]);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama_partner' => 'required|string|max:255',
      'url_partner' => 'required|url|max:255',
      'foto_partner' => 'nullable',
    ]);

    $partner = Partner::findOrFail($id);
    $partner->nama_partner = $request->input('nama_partner');
    $partner->url_partner = $request->input('url_partner');

    $slug = Str::slug($request->input('nama_partner'));
    $baru = UploadGambar::simpan($request, 'foto_partner', "partner/{$slug}", $partner->foto_partner);
    if ($baru !== null) {
      $partner->foto_partner = $baru;
    }

    $partner->save();

    return redirect()->route('admin.partner.index')->with('success', 'Partner berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $partner = Partner::findOrFail($id);

    if (Storage::disk('public')->exists($partner->foto_partner)) {
      Storage::disk('public')->delete($partner->foto_partner);
    }

    $partner->delete();

    return redirect()->route('admin.partner.index')->with('success', 'Partner berhasil dihapus.');
  }
}

