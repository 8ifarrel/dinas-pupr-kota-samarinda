<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\KepalaDinasRiwayatPendidikan;
use App\Models\KepalaDinasJenjangKarir;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KepalaDinasAdminController extends Controller
{
    public function index()
    {
        $page_title = "Kepala Dinas PUPR Samarinda";
        $kepalaDinas = SusunanOrganisasi::where('kelompok_susunan_organisasi', 'Kepala Dinas')->get();
        $jabatan = $kepalaDinas->first();
        $visi = Visi::all();
        $misi = Misi::orderBy('nomor_urut')->get();
        $riwayatPendidikan = KepalaDinasRiwayatPendidikan::where('id_susunan_organisasi', $kepalaDinas->first()->id_susunan_organisasi)->get();
        $jenjangKarir = KepalaDinasJenjangKarir::where('id_susunan_organisasi', $kepalaDinas->first()->id_susunan_organisasi)->get();

        return view('admin.pages.kepala-dinas.index', compact('kepalaDinas', 'jabatan', 'visi', 'misi', 'riwayatPendidikan', 'jenjangKarir', 'page_title'));
    }

    public function edit()
    {
        $page_title = "Edit Kepala Dinas PUPR Samarinda";
        $kepalaDinas = SusunanOrganisasi::where('kelompok_susunan_organisasi', 'Kepala Dinas')->first();
        $visi = Visi::all();
        $misi = Misi::orderBy('nomor_urut')->get();
        $riwayatPendidikan = KepalaDinasRiwayatPendidikan::where('id_susunan_organisasi', $kepalaDinas->id_susunan_organisasi)->get();
        $jenjangKarir = KepalaDinasJenjangKarir::where('id_susunan_organisasi', $kepalaDinas->id_susunan_organisasi)->get();

        return view('admin.pages.kepala-dinas.edit', compact('kepalaDinas', 'visi', 'misi', 'riwayatPendidikan', 'jenjangKarir', 'page_title'));
    }

    public function update(Request $request)
    {
        $kepalaDinas = SusunanOrganisasi::where('kelompok_susunan_organisasi', 'Kepala Dinas')->first();

        $kepalaDinas->update($request->except(['foto_pegawai', 'riwayat_pendidikan', 'tanggal_masuk_pendidikan', 'jenjang_karir', 'tanggal_masuk_karir', 'periode_mulai', 'periode_selesai', 'username', 'email', 'password', 'current_password']));

        if ($request->has('foto_pegawai')) {
            $fotoPegawaiData = json_decode($request->input('foto_pegawai'), true);
            if (isset($fotoPegawaiData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoPegawaiData['fileUrl']);
                $slugNama = Str::slug($kepalaDinas->nama_susunan_organisasi);
                $newFileName = 'pegawai/kepala-dinas/' . $slugNama . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $kepalaDinas->foto_pegawai = $newFileName;
                $kepalaDinas->save();
            }
        }

        // Update deskripsi jabatan and tupoksi jabatan
        $kepalaDinas->update([
            'deskripsi_susunan_organisasi' => $request->input('deskripsi_jabatan'),
            'tupoksi_susunan_organisasi' => $request->input('tupoksi_jabatan'),
        ]);

        // Update visi and misi
        $visi = Visi::all();
        foreach ($visi as $visiItem) {
            $visiItem->update([
                'deskripsi_visi' => $request->input('visi'),
                'periode_mulai' => $request->input('periode_mulai'),
                'periode_selesai' => $request->input('periode_selesai'),
            ]);
        }

        Misi::truncate();
        if ($request->has('misi')) {
            foreach ($request->input('misi') as $index => $deskripsi_misi) {
                Misi::create([
                    'nomor_urut' => $index + 1,
                    'deskripsi_misi' => $deskripsi_misi,
                    'periode_mulai' => $request->input('periode_mulai'),
                    'periode_selesai' => $request->input('periode_selesai'),
                ]);
            }
        }

        // Update riwayat pendidikan
        KepalaDinasRiwayatPendidikan::where('id_susunan_organisasi', $kepalaDinas->id_susunan_organisasi)->delete();
        if ($request->has('riwayat_pendidikan')) {
            foreach ($request->riwayat_pendidikan as $index => $nama_pendidikan) {
                KepalaDinasRiwayatPendidikan::create([
                    'nama_pendidikan' => $nama_pendidikan,
                    'tanggal_masuk' => $request->tanggal_masuk_pendidikan[$index],
                    'id_susunan_organisasi' => $kepalaDinas->id_susunan_organisasi,
                ]);
            }
        }

        // Update jenjang karir
        KepalaDinasJenjangKarir::where('id_susunan_organisasi', $kepalaDinas->id_susunan_organisasi)->delete();
        if ($request->has('jenjang_karir')) {
            foreach ($request->jenjang_karir as $index => $nama_karir) {
                KepalaDinasJenjangKarir::create([
                    'nama_karir' => $nama_karir,
                    'tanggal_masuk' => $request->tanggal_masuk_karir[$index],
                    'id_susunan_organisasi' => $kepalaDinas->id_susunan_organisasi,
                ]);
            }
        }

        // Update user account details
        $user = $kepalaDinas->user ?? null;
        $usernameChanged = $user && $user->name !== $request->input('username');
        $emailChanged = $user && $user->email !== $request->input('email');
        $passwordChanged = $user && $request->filled('password');

        if ($user && ($usernameChanged || $emailChanged || $passwordChanged)) {
            if ($request->filled('current_password')) {
                if (Hash::check($request->input('current_password'), $user->password)) {
                    $user->name = $request->input('username');
                    $user->email = $request->input('email');

                    if ($passwordChanged) {
                        $user->password = Hash::make($request->input('password'));
                    }

                    $user->save();
                } else {
                    return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
                }
            } else {
                return redirect()->back()->withErrors(['current_password' => 'Password lama wajib diisi untuk mengubah akun.']);
            }
        }

        return redirect()->route('admin.kepala-dinas.index')->with('success', 'Data Kepala Dinas berhasil diperbarui.');
    }
}
