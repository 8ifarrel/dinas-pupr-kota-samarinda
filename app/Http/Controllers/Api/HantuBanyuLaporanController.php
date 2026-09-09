<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\HantuBanyuPengaduanGuestController;
use App\Models\HantuBanyuLaporan;
use App\Models\HantuBanyuLaporanFoto;
use App\Models\HantuBanyuLaporanTindakLanjut;
use App\Models\HantuBanyuPelapor;
use App\Models\Kelurahan;
use App\Models\SKM;
use App\Support\HantuBanyu\VerifikasiKoordinatKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Pengiriman laporan Hantu Banyu lewat API, untuk sistem pihak ketiga yang
 * tidak memakai formulir web. Dilindungi kunci API Hantu Banyu.
 *
 * Perbedaan dengan formulir web: formulir mengunci wilayah ke akun kelurahan
 * yang login, sedangkan klien API tidak punya sesi. Karena itu kelurahan
 * dikirim eksplisit di badan permintaan, dan aturan wilayahnya tetap
 * ditegakkan lewat verifikasi koordinat yang sama (lihat koordinatDiKelurahan()
 * di bawah).
 */
class HantuBanyuLaporanController extends Controller
{
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nama_lengkap' => 'required|string|max:100',
      'alamat' => 'required|string',
      'nomor_telepon' => ['required', 'regex:/^08[0-9]{8,13}$/'],
      'kelurahan_id' => 'required|integer|exists:kelurahan,id',
      'nama_jalan' => 'required|string|max:150',
      'latitude' => ['required', 'regex:/^[-+]?\d{1,3}\.\d{7}$/'],
      'longitude' => ['required', 'regex:/^[-+]?\d{1,3}\.\d{7}$/'],
      'detail_lokasi' => 'required|string',
      'deskripsi_pengaduan' => 'required|string',
      'foto' => 'required|array|min:1',
      'foto.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
      'skm_nilai' => 'nullable|integer|min:1|max:4',
      'skm_kritik' => 'nullable|string',
      'skm_saran' => 'nullable|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Data yang diberikan tidak valid.',
        'errors' => $validator->errors(),
      ], 422);
    }

    // Kecamatan diturunkan dari kelurahan, tidak diambil dari permintaan,
    // supaya pasangan kecamatan-kelurahan selalu konsisten.
    $kelurahan = Kelurahan::with('kecamatan')->findOrFail($request->input('kelurahan_id'));

    $lokasiValid = VerifikasiKoordinatKelurahan::koordinatDiKelurahan(
      $request->input('latitude'),
      $request->input('longitude'),
      $kelurahan->nama,
      optional($kelurahan->kecamatan)->nama ?? ''
    );

    if ($lokasiValid === null) {
      return response()->json([
        'success' => false,
        'message' => 'Lokasi tidak dapat diverifikasi saat ini. Silakan coba beberapa saat lagi.',
      ], 503);
    }

    if (!$lokasiValid) {
      return response()->json([
        'success' => false,
        'message' => 'Titik koordinat berada di luar Kelurahan ' . $kelurahan->nama . '.',
        'errors' => [
          'latitude' => ['Koordinat tidak berada di dalam kelurahan yang dilaporkan.'],
        ],
      ], 422);
    }

    DB::beginTransaction();
    try {
      $pelapor = HantuBanyuPelapor::create([
        'nama_lengkap' => $request->input('nama_lengkap'),
        'kelurahan_asal_id' => $kelurahan->id,
        'alamat' => $request->input('alamat'),
        'nomor_telepon' => $request->input('nomor_telepon'),
      ]);

      $laporan = HantuBanyuLaporan::create([
        'pelapor_id' => $pelapor->id,
        'nama_jalan' => $request->input('nama_jalan'),
        'kecamatan_id' => $kelurahan->kecamatan_id,
        'kelurahan_id' => $kelurahan->id,
        'longitude' => $request->input('longitude'),
        'latitude' => $request->input('latitude'),
        'detail_lokasi' => $request->input('detail_lokasi'),
        'deskripsi_pengaduan' => $request->input('deskripsi_pengaduan'),
      ]);

      HantuBanyuLaporanTindakLanjut::create([
        'laporan_id' => $laporan->id,
        'status' => 'pending',
        'deskripsi' => 'Laporan telah masuk. Mohon menunggu proses lebih lanjut',
        'jenis' => 'belum_diklasifikasikan',
      ]);

      $i = 1;
      foreach ($request->file('foto') as $file) {
        if (!$file || !$file->isValid()) {
          continue;
        }

        $namaFoto = "foto{$i}_" . now()->format('HisdmY') . '.' . $file->getClientOriginalExtension();
        $file->storeAs("public/hantu-banyu/{$laporan->id}/foto_laporan", $namaFoto);

        HantuBanyuLaporanFoto::create([
          'laporan_id' => $laporan->id,
          'foto' => "hantu-banyu/{$laporan->id}/foto_laporan/{$namaFoto}",
        ]);

        $i++;
      }

      $skm = SKM::create([
        'nilai' => $request->input('skm_nilai'),
        'ip_address' => $request->ip(),
        'kritik' => trim((string) $request->input('skm_kritik')) ?: null,
        'saran' => trim((string) $request->input('skm_saran')) ?: null,
        'layanan_id' => (new HantuBanyuPengaduanGuestController)->layanan_id,
      ]);

      $pelapor->skm_id = $skm->id;
      $pelapor->save();

      DB::commit();

      return response()->json([
        'success' => true,
        'message' => 'Laporan berhasil dikirim. Mohon menunggu proses lebih lanjut.',
        'data' => [
          'id_laporan' => $laporan->id,
          'status' => 'pending',
          'kecamatan' => optional($kelurahan->kecamatan)->nama,
          'kelurahan' => $kelurahan->nama,
          'jumlah_foto' => $laporan->foto()->count(),
          'detail_url' => route('api.hantu-banyu-laporan.show', $laporan->id),
        ],
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Gagal membuat laporan Hantu Banyu dari API: ' . $e->getMessage(), [
        'trace' => $e->getTraceAsString(),
        'request' => $request->except('foto'),
      ]);

      return response()->json([
        'success' => false,
        'message' => 'Terjadi kesalahan internal pada server. Silakan coba lagi nanti.',
      ], 500);
    }
  }

  public function show($id)
  {
    try {
      $laporan = HantuBanyuLaporan::with(['kecamatan', 'kelurahan', 'foto'])->findOrFail($id);

      $tindakLanjut = $laporan->tindakLanjut()->orderByDesc('created_at')->first();

      return response()->json([
        'success' => true,
        'message' => 'Data laporan berhasil diambil.',
        'data' => [
          'id_laporan' => $laporan->id,
          'nama_jalan' => $laporan->nama_jalan,
          'detail_lokasi' => $laporan->detail_lokasi,
          'deskripsi_pengaduan' => $laporan->deskripsi_pengaduan,
          'kecamatan' => optional($laporan->kecamatan)->nama,
          'kelurahan' => optional($laporan->kelurahan)->nama,
          'latitude' => $laporan->latitude,
          'longitude' => $laporan->longitude,
          'link_koordinat' => "https://maps.google.com/?q={$laporan->latitude},{$laporan->longitude}",
          'status' => optional($tindakLanjut)->status,
          'jenis' => optional($tindakLanjut)->jenis,
          'keterangan_status' => optional($tindakLanjut)->deskripsi,
          'foto' => $laporan->foto->map(fn($f) => asset('storage/' . $f->foto))->all(),
          'dibuat_pada' => $laporan->created_at?->isoFormat('DD MMMM YYYY, HH:mm') . ' WITA',
        ],
      ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'success' => false,
        'message' => 'Laporan tidak ditemukan.',
      ], 404);
    }
  }

}
