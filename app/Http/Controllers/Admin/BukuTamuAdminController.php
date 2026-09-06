<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BukuTamu;

class BukuTamuAdminController extends Controller
{
  public function index()
  {
    // Memakai facade Auth, bukan helper auth(). Helper itu dideklarasikan
    // mengembalikan AuthFactory|Guard, dan AuthFactory hanya punya guard()
    // serta shouldUse() sehingga user() dianggap tidak ada. Sisa controller
    // di proyek ini juga memakai facade, jadi sekalian seragam.
    //
    // Anotasi di bawah diperlukan karena guard mengembalikan kontrak
    // Authenticatable, sedangkan model sebenarnya baru ditentukan
    // config/auth.php saat aplikasi berjalan.
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    $susunanOrganisasi = $user->susunanOrganisasi ?? null;
    $id_kepala_dinas = 1;

    if (
      ($user && $user->is_super_admin) ||
      ($susunanOrganisasi && in_array($susunanOrganisasi->id_susunan_organisasi, [$id_kepala_dinas]))
    ) {
      $bukuTamu = BukuTamu::with('susunanOrganisasi')->orderBy('created_at', 'desc')->get();
    } else {
      $susunanOrganisasiId = $susunanOrganisasi ? $susunanOrganisasi->id_susunan_organisasi : null;
      $bukuTamu = BukuTamu::with('susunanOrganisasi')
        ->where('jabatan_yang_dikunjungi', $susunanOrganisasiId)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    $page_title = "Buku Tamu";
    $page_description = "Lihat dan kelola tamu yang ingin berkunjung ke Dinas PUPR Kota Samarinda";

    return view('admin.pages.buku-tamu.index', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'bukuTamu' => $bukuTamu,
    ]);
  }

  public function edit($id)
  {
    $bukuTamu = BukuTamu::findOrFail($id);
    $page_title = "Edit Buku Tamu";
    $page_description = "Kelola status kunjungan secara berkala agar tamu dapat memantau proses pengajuan kunjungannya.";

    return view('admin.pages.buku-tamu.edit', [
      'page_title' => $page_title,
      'page_description' => $page_description,
      'bukuTamu' => $bukuTamu,
    ]);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|string',
      'deskripsi_status' => 'nullable|string',
    ]);

    $bukuTamu = BukuTamu::findOrFail($id);
    $bukuTamu->status = $request->status;
    $bukuTamu->deskripsi_status = $request->deskripsi_status;
    $bukuTamu->save();

    return redirect()->route('admin.buku-tamu.index')
      ->with('success', 'Status Buku Tamu berhasil diperbarui.');
  }
}