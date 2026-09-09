<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use App\Models\KepalaDinas;
use App\Models\KepalaDinasRiwayatPendidikan;
use App\Models\KepalaDinasJenjangKarir;
use App\Support\Shared\UploadGambar;
use Illuminate\Support\Str;

class KepalaDinasAdminController extends Controller
{
  public function edit()
  {
    $page_title = "Edit Kepala Dinas PUPR Samarinda";
    $page_description = "Isi form untuk mengubah biodata Kepala Dinas.";
    $susunan = SusunanOrganisasi::where('kelompok_susunan_organisasi', 'Kepala Dinas')->first();
    $kepalaDinas = KepalaDinas::where('id_susunan_organisasi', $susunan->id_susunan_organisasi)->first();
    $riwayatPendidikan = KepalaDinasRiwayatPendidikan::where('id_susunan_organisasi', $susunan->id_susunan_organisasi)->get();
    $jenjangKarir = KepalaDinasJenjangKarir::where('id_susunan_organisasi', $susunan->id_susunan_organisasi)->get();

    return view('admin.pages.kepala-dinas.edit', [
      'kepalaDinas' => $kepalaDinas,
      'susunan' => $susunan,
      'riwayatPendidikan' => $riwayatPendidikan,
      'jenjangKarir' => $jenjangKarir,
      'page_title' => $page_title,
      'page_description' => $page_description,
    ]);
  }

  public function update(Request $request)
  {
    $golonganList = ['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'];

    $request->validate([
      'golongan_pegawai' => ['required', 'in:' . implode(',', $golonganList)],
    ]);

    $susunan = SusunanOrganisasi::where('kelompok_susunan_organisasi', 'Kepala Dinas')->first();
    $kepalaDinas = KepalaDinas::where('id_susunan_organisasi', $susunan->id_susunan_organisasi)->first();

    // Update SusunanOrganisasi fields
    $susunan->update($request->except([
      'foto',
      'riwayat_pendidikan',
      'tanggal_masuk_pendidikan',
      'jenjang_karir',
      'tanggal_masuk_karir',
      'tahun_mulai',
      'tahun_selesai',
    ]));

    // Update tahun_mulai dan tahun_selesai di KepalaDinas
    if ($kepalaDinas) {
      $kepalaDinas->tahun_mulai = $request->input('tahun_mulai');
      $kepalaDinas->tahun_selesai = $request->input('tahun_selesai');
      $kepalaDinas->save();
    }

    // Update foto
    $slugNama = Str::slug($susunan->nama_susunan_organisasi);
    $baru = UploadGambar::simpan($request, 'foto', "pegawai/kepala-dinas/{$slugNama}", $susunan->foto);
    if ($baru !== null) {
      $susunan->foto = $baru;
      $susunan->save();
    }

    // Update deskripsi jabatan and tupoksi jabatan
    $susunan->update([
      'deskripsi_susunan_organisasi' => $request->input('deskripsi_jabatan'),
      'tupoksi_susunan_organisasi' => $request->input('tupoksi_jabatan'),
    ]);

    // Update riwayat pendidikan
    KepalaDinasRiwayatPendidikan::where('id_susunan_organisasi', $susunan->id_susunan_organisasi)->delete();
    if ($request->has('riwayat_pendidikan')) {
      foreach ($request->riwayat_pendidikan as $index => $nama_pendidikan) {
        KepalaDinasRiwayatPendidikan::create([
          'nama_pendidikan' => $nama_pendidikan,
          'tanggal_masuk' => $request->tanggal_masuk_pendidikan[$index],
          'id_susunan_organisasi' => $susunan->id_susunan_organisasi,
        ]);
      }
    }

    // Update jenjang karir
    KepalaDinasJenjangKarir::where('id_susunan_organisasi', $susunan->id_susunan_organisasi)->delete();
    if ($request->has('jenjang_karir')) {
      foreach ($request->jenjang_karir as $index => $nama_karir) {
        KepalaDinasJenjangKarir::create([
          'nama_karir' => $nama_karir,
          'tanggal_masuk' => $request->tanggal_masuk_karir[$index],
          'id_susunan_organisasi' => $susunan->id_susunan_organisasi,
        ]);
      }
    }

    return redirect()->route('admin.kepala-dinas.edit')->with('success', 'Data Kepala Dinas berhasil diperbarui.');
  }
}
