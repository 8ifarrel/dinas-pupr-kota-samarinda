<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * API akun kelurahan, dijaga kunci API "akun-kelurahan".
 *
 * Gunanya persis alasan akun kelurahan ditaruh di level super admin: fitur
 * baru - termasuk yang berjalan di luar web ini - bisa memakai ulang akun
 * kelurahan yang sudah ada, tanpa perlu membangun sistem akun sendiri.
 *
 * Kunci fitur lain (Jalan Peduli, Hantu Banyu) tidak berlaku di sini, begitu
 * pula sebaliknya, karena tiap fitur punya tabel kuncinya masing-masing.
 */
class AkunKelurahanController extends Controller
{
  /**
   * Daftar akun kelurahan. Sengaja tanpa kolom sandi sama sekali: yang
   * dibutuhkan pemanggil hanya "kelurahan mana saja yang punya akun".
   */
  public function index(Request $request)
  {
    $kecamatanId = $request->query('kecamatan_id');

    $akun = UserKelurahan::with('kelurahan.kecamatan')
      ->when($kecamatanId, function ($q) use ($kecamatanId) {
        $q->whereHas('kelurahan', fn($qq) => $qq->where('kecamatan_id', $kecamatanId));
      })
      ->get()
      ->map(fn($a) => $this->bentukAkun($a))
      ->sortBy('kelurahan.nama')
      ->values();

    return response()->json([
      'success' => true,
      'message' => 'Daftar akun kelurahan berhasil diambil',
      'data' => $akun,
      'total' => $akun->count(),
    ]);
  }

  /**
   * Detail satu akun kelurahan.
   */
  public function show($id)
  {
    $akun = UserKelurahan::with('kelurahan.kecamatan')->find($id);

    if (!$akun) {
      return response()->json([
        'success' => false,
        'message' => 'Akun kelurahan tidak ditemukan',
      ], 404);
    }

    return response()->json([
      'success' => true,
      'message' => 'Akun kelurahan berhasil diambil',
      'data' => $this->bentukAkun($akun),
    ]);
  }

  /**
   * Verifikasi username + kata sandi akun kelurahan.
   *
   * Inilah yang membuat akun kelurahan bisa dipakai ulang oleh fitur lain:
   * pemanggil cukup menitipkan kredensial yang diisi warga/petugas, lalu
   * menerima identitas kelurahannya bila cocok. Pemeriksaan dilakukan lewat
   * provider guard "kelurahan" yang sama persis dengan login web, jadi tidak
   * mungkin ada perbedaan pendapat soal sandi mana yang sah.
   */
  public function verifikasi(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'password' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Validasi gagal',
        'errors' => $validator->errors(),
      ], 422);
    }

    $provider = Auth::guard('kelurahan')->getProvider();
    $akun = $provider->retrieveByCredentials(['name' => $request->input('name')]);

    // Pesan sengaja disamakan untuk username tidak dikenal maupun sandi
    // salah, supaya endpoint ini tidak bisa dipakai menebak username mana
    // yang terdaftar.
    if (!$akun || !$provider->validateCredentials($akun, ['password' => $request->input('password')])) {
      return response()->json([
        'success' => false,
        'message' => 'Username atau kata sandi salah',
        'valid' => false,
      ], 401);
    }

    $akun->loadMissing('kelurahan.kecamatan');

    return response()->json([
      'success' => true,
      'message' => 'Kredensial akun kelurahan valid',
      'valid' => true,
      'data' => $this->bentukAkun($akun),
    ]);
  }

  /**
   * Bentuk balasan satu akun. Disusun eksplisit, bukan dari toArray(), supaya
   * kolom sensitif tidak pernah ikut terbawa hanya karena model berubah.
   */
  private function bentukAkun(UserKelurahan $akun): array
  {
    return [
      'id' => $akun->id,
      'fullname' => $akun->fullname,
      'username' => $akun->name,
      'kelurahan' => [
        'id' => optional($akun->kelurahan)->id,
        'nama' => optional($akun->kelurahan)->nama,
      ],
      'kecamatan' => [
        'id' => optional(optional($akun->kelurahan)->kecamatan)->id,
        'nama' => optional(optional($akun->kelurahan)->kecamatan)->nama,
      ],
      'created_at' => $akun->created_at,
    ];
  }
}
