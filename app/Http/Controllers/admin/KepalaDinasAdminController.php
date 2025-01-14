<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\KepalaDinasRiwayatPendidikan;
use App\Models\KepalaDinasJenjangKarir;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KepalaDinasAdminController extends Controller
{
    public function index()
    {
        $page_title = "Kepala Dinas PUPR Samarinda";
        $kepalaDinas = Pegawai::where('id_jabatan', 1)->get();
        $jabatan = $kepalaDinas->first()->jabatan;
        $visi = Visi::all();
        $misi = Misi::all();
        $riwayatPendidikan = KepalaDinasRiwayatPendidikan::where('id_pegawai', $kepalaDinas->first()->id_pegawai)->get();
        $jenjangKarir = KepalaDinasJenjangKarir::where('id_pegawai', $kepalaDinas->first()->id_pegawai)->get();

        return view('admin.pages.kepala-dinas.index', compact('kepalaDinas', 'jabatan', 'visi', 'misi', 'riwayatPendidikan', 'jenjangKarir', 'page_title'));
    }

    public function edit()
    {
        $page_title = "Edit Kepala Dinas PUPR Samarinda";
        $kepalaDinas = Pegawai::where('id_jabatan', 1)->first();
        $visi = Visi::all();
        $misi = Misi::all();
        $riwayatPendidikan = KepalaDinasRiwayatPendidikan::where('id_pegawai', $kepalaDinas->id_pegawai)->get();
        $jenjangKarir = KepalaDinasJenjangKarir::where('id_pegawai', $kepalaDinas->id_pegawai)->get();

        return view('admin.pages.kepala-dinas.edit', compact('kepalaDinas', 'visi', 'misi', 'riwayatPendidikan', 'jenjangKarir', 'page_title'));
    }

    public function update(Request $request)
    {
        $kepalaDinas = Pegawai::where('id_jabatan', 1)->first();

        $kepalaDinas->update($request->except(['foto_pegawai', 'riwayat_pendidikan', 'tanggal_masuk_pendidikan', 'jenjang_karir', 'tanggal_masuk_karir', 'periode_mulai', 'periode_selesai']));

        if ($request->has('foto_pegawai')) {
            $fotoPegawaiData = json_decode($request->input('foto_pegawai'), true);
            if (isset($fotoPegawaiData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoPegawaiData['fileUrl']);
                $slugNamaPegawai = Str::slug($kepalaDinas->nama_pegawai);
                $newFileName = 'pegawai/kepala-dinas/' . $slugNamaPegawai . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $kepalaDinas->foto_pegawai = $newFileName;
                $kepalaDinas->save();
            }
        }

        KepalaDinasRiwayatPendidikan::where('id_pegawai', $kepalaDinas->id_pegawai)->delete();
        if ($request->has('riwayat_pendidikan')) {
            foreach ($request->riwayat_pendidikan as $index => $nama_pendidikan) {
                KepalaDinasRiwayatPendidikan::create([
                    'nama_pendidikan' => $nama_pendidikan,
                    'tanggal_masuk' => $request->tanggal_masuk_pendidikan[$index],
                    'id_pegawai' => $kepalaDinas->id_pegawai,
                ]);
            }
        }

        KepalaDinasJenjangKarir::where('id_pegawai', $kepalaDinas->id_pegawai)->delete();
        if ($request->has('jenjang_karir')) {
            foreach ($request->jenjang_karir as $index => $nama_karir) {
                KepalaDinasJenjangKarir::create([
                    'nama_karir' => $nama_karir,
                    'tanggal_masuk' => $request->tanggal_masuk_karir[$index],
                    'id_pegawai' => $kepalaDinas->id_pegawai,
                ]);
            }
        }

        if ($request->has(['periode_mulai', 'periode_selesai'])) {
            $visi = Visi::all();
            foreach ($visi as $visiItem) {
                $visiItem->update([
                    'periode_mulai' => $request->periode_mulai,
                    'periode_selesai' => $request->periode_selesai,
                ]);
            }

            $misi = Misi::all();
            foreach ($misi as $misiItem) {
                $misiItem->update([
                    'periode_mulai' => $request->periode_mulai,
                    'periode_selesai' => $request->periode_selesai,
                ]);
            }
        }

        return redirect()->route('admin.kepala-dinas.index')->with('success', 'Data Kepala Dinas berhasil diperbarui.');
    }
}
