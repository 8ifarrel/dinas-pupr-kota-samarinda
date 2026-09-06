<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\SilaladGuestController;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Silalad;
use App\Models\SKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Pendaftaran dan pemantauan pesanan SILALAD lewat API, untuk sistem pihak
 * ketiga yang tidak memakai formulir web. Dilindungi kunci API SILALAD.
 *
 * Perbedaan dengan formulir web: formulir mengisi kecamatan/kelurahan lewat
 * dropdown bertingkat (internal untuk Samarinda, API wilayah pihak ketiga
 * untuk luar Samarinda). Klien API mengirimkannya langsung, dengan aturan
 * yang sama seperti yang disimpan formulir: untuk Samarinda dipakai id
 * numerik internal, untuk luar Samarinda dipakai nama wilayahnya (lihat
 * normalisasiWilayah() di bawah).
 */
class SilaladPesananController extends Controller
{
  private const STATUS = ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'];

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nama_pelanggan' => 'required|string|max:150',
      'nomor_telepon_pelanggan' => ['required', 'regex:/^08[0-9]{8,13}$/'],
      'alamat' => 'required|string|max:255',
      'kabkota_id' => 'required|string|max:50',
      'kecamatan_id' => 'required|string|max:50',
      'kelurahan_id' => 'required|string|max:50',
      'alamat_detail' => 'nullable|string|max:255',
      'layanan' => 'nullable|string|max:50',
      'detail_laporan' => 'nullable|string',
      'jenis_bangunan' => 'required|string|max:20',
      'jenis_bangunan_lainnya' => 'nullable|string|max:100',
      'rt' => 'required|numeric',
      'nomor_bangunan' => 'required|numeric',
      'latitude' => 'nullable|numeric',
      'longitude' => 'nullable|numeric',
      'setuju' => 'nullable|boolean',
      'skm_nilai' => 'nullable|integer|min:1|max:5',
      'skm_kritik' => 'nullable|string',
      'skm_saran' => 'nullable|string',
    ], [
      'nomor_telepon_pelanggan.regex' => 'Nomor telepon harus diawali 08 dan terdiri dari 10-15 digit.',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Data yang diberikan tidak valid.',
        'errors' => $validator->errors(),
      ], 422);
    }

    $wilayah = $this->normalisasiWilayah(
      $request->input('kabkota_id'),
      $request->input('kecamatan_id'),
      $request->input('kelurahan_id')
    );

    if (isset($wilayah['error'])) {
      return response()->json([
        'success' => false,
        'message' => 'Data wilayah tidak valid.',
        'errors' => $wilayah['error'],
      ], 422);
    }

    // Opsi "Lainnya" pada jenis bangunan diganti isian bebasnya, sama
    // seperti perlakuan formulir web.
    $jenisBangunan = $request->input('jenis_bangunan');
    if (strcasecmp($jenisBangunan, 'Lainnya') === 0 && filled($request->input('jenis_bangunan_lainnya'))) {
      $jenisBangunan = $request->input('jenis_bangunan_lainnya');
    }

    $kritik = trim((string) $request->input('skm_kritik')) ?: null;
    $saran = trim((string) $request->input('skm_saran')) ?: null;

    DB::beginTransaction();
    try {
      $pesanan = Silalad::create([
        'nama_pelanggan' => $request->input('nama_pelanggan'),
        'nomor_telepon_pelanggan' => $request->input('nomor_telepon_pelanggan'),
        'alamat' => $request->input('alamat'),
        'alamat_detail' => $request->input('alamat_detail'),
        'layanan' => $request->input('layanan'),
        'detail_laporan' => $request->input('detail_laporan'),
        'kabkota_id' => $wilayah['kabkota_id'],
        'kecamatan_id' => $wilayah['kecamatan_id'],
        'kelurahan_id' => $wilayah['kelurahan_id'],
        'latitude' => $request->input('latitude'),
        'longitude' => $request->input('longitude'),
        'jenis_bangunan' => $jenisBangunan,
        'rt' => $request->input('rt'),
        'nomor_bangunan' => $request->input('nomor_bangunan'),
        'rating' => $request->input('skm_nilai'),
        // Kolom saran_masukan di tabel silalad cuma satu, jadi kritik dan
        // saran digabung di situ - konvensi yang sama dipakai formulir web.
        'saran_masukan' => collect([$kritik, $saran])->filter()->implode("\n"),
        'setuju' => $request->boolean('setuju'),
      ]);

      // Rekap survei kepuasan masuk ke tabel `skm` bersama (id layanan
      // SILALAD), kritik dan saran tetap terpisah di sana.
      SKM::create([
        'nilai' => $request->input('skm_nilai'),
        'ip_address' => $request->ip(),
        'kritik' => $kritik,
        'saran' => $saran,
        'layanan_id' => (new SilaladGuestController)->layanan_id,
      ]);

      // status_pengerjaan diisi lewat nilai bawaan kolom di basis data, jadi
      // model hasil create() belum memuatnya - ambil ulang supaya balasan
      // tidak mengembalikan status null.
      $pesanan->refresh();

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Gagal membuat pesanan SILALAD dari API: ' . $e->getMessage(), [
        'trace' => $e->getTraceAsString(),
        'request' => $request->all(),
      ]);

      return response()->json([
        'success' => false,
        'message' => 'Terjadi kesalahan internal pada server. Silakan coba lagi nanti.',
      ], 500);
    }

    // Notifikasi ke admin dikirim setelah transaksi berhasil di-commit,
    // supaya email tidak terkirim untuk pesanan yang batal tersimpan.
    $this->kirimNotifikasiAdmin($pesanan);

    return response()->json([
      'success' => true,
      'message' => 'Pendaftaran berhasil dikirim. Tim kami akan segera memproses.',
      'data' => [
        'id_pesanan' => $pesanan->id,
        'kode_booking' => $pesanan->kode_booking,
        'status' => $pesanan->status_pengerjaan,
        'kabkota' => $pesanan->kabkota_id,
        'kecamatan' => $this->namaKecamatan($pesanan->kecamatan_id),
        'kelurahan' => $this->namaKelurahan($pesanan->kelurahan_id),
        'detail_url' => route('api.silalad-pesanan.show', $pesanan->id),
      ],
    ], 201);
  }

  public function show($id)
  {
    try {
      $pesanan = Silalad::findOrFail($id);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'success' => false,
        'message' => 'Pesanan tidak ditemukan.',
      ], 404);
    }

    return response()->json([
      'success' => true,
      'message' => 'Data pesanan berhasil diambil.',
      'data' => $this->format($pesanan),
    ]);
  }

  /**
   * Daftar pesanan milik satu nomor telepon, sepadan dengan halaman "Cek
   * Status" di sisi web. Nomor telepon wajib supaya endpoint ini tidak
   * berubah menjadi daftar seluruh pesanan pelanggan.
   */
  public function status(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nomor_telepon_pelanggan' => 'required|string|max:15',
      'status' => ['nullable', 'string', 'in:' . implode(',', self::STATUS)],
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Data yang diberikan tidak valid.',
        'errors' => $validator->errors(),
      ], 422);
    }

    $pesanan = Silalad::where('nomor_telepon_pelanggan', $request->input('nomor_telepon_pelanggan'))
      ->when($request->filled('status'), fn($q) => $q->where('status_pengerjaan', $request->input('status')))
      ->orderByDesc('created_at')
      ->get();

    return response()->json([
      'success' => true,
      'message' => 'Data pesanan berhasil diambil.',
      'total' => $pesanan->count(),
      'data' => $pesanan->map(fn($p) => $this->format($p))->all(),
    ]);
  }

  /** @return array<string,mixed> bentuk balasan satu pesanan, dipakai show() dan status() */
  private function format(Silalad $pesanan): array
  {
    return [
      'id_pesanan' => $pesanan->id,
      'kode_booking' => $pesanan->kode_booking,
      'status' => $pesanan->status_pengerjaan,
      'nama_pelanggan' => $pesanan->nama_pelanggan,
      'nomor_telepon_pelanggan' => $pesanan->nomor_telepon_pelanggan,
      'alamat' => $pesanan->alamat,
      'alamat_detail' => $pesanan->alamat_detail,
      'layanan' => $pesanan->layanan,
      'detail_laporan' => $pesanan->detail_laporan,
      'jenis_bangunan' => $pesanan->jenis_bangunan,
      'kabkota' => $pesanan->kabkota_id,
      'kecamatan' => $this->namaKecamatan($pesanan->kecamatan_id),
      'kelurahan' => $this->namaKelurahan($pesanan->kelurahan_id),
      'rt' => $pesanan->rt,
      'nomor_bangunan' => $pesanan->nomor_bangunan,
      'latitude' => $pesanan->latitude,
      'longitude' => $pesanan->longitude,
      'link_koordinat' => ($pesanan->latitude && $pesanan->longitude)
        ? "https://maps.google.com/?q={$pesanan->latitude},{$pesanan->longitude}"
        : null,
      'setuju_biaya_tambahan' => (bool) $pesanan->setuju,
      'dibuat_pada' => $pesanan->created_at?->isoFormat('DD MMMM YYYY, HH:mm') . ' WITA',
    ];
  }

  /**
   * Samakan bentuk data wilayah dengan yang disimpan formulir web: di
   * Samarinda kecamatan/kelurahan disimpan sebagai id numerik internal dan
   * karenanya divalidasi keberadaannya (termasuk apakah kelurahan memang
   * milik kecamatan tsb); di luar Samarinda kolomnya berisi nama wilayah
   * apa adanya, karena datanya berasal dari API wilayah pihak ketiga yang
   * idnya tidak ada di basis data ini.
   *
   * @return array{kabkota_id:string,kecamatan_id:string,kelurahan_id:string}|array{error:array<string,array<int,string>>}
   */
  private function normalisasiWilayah(string $kabkota, string $kecamatan, string $kelurahan): array
  {
    $diSamarinda = str_contains(strtolower($kabkota), 'samarinda');

    if (!$diSamarinda) {
      return [
        'kabkota_id' => $kabkota,
        'kecamatan_id' => $kecamatan,
        'kelurahan_id' => $kelurahan,
      ];
    }

    if (!ctype_digit($kecamatan) || !ctype_digit($kelurahan)) {
      return [
        'error' => [
          'kecamatan_id' => ['Untuk Kota Samarinda, kecamatan_id dan kelurahan_id harus berupa id numerik internal (lihat GET /api/kecamatans).'],
        ],
      ];
    }

    $kelurahanModel = Kelurahan::find($kelurahan);

    if (!Kecamatan::find($kecamatan) || !$kelurahanModel) {
      return [
        'error' => [
          'kecamatan_id' => ['Kecamatan atau kelurahan tidak ditemukan.'],
        ],
      ];
    }

    if ((string) $kelurahanModel->kecamatan_id !== (string) $kecamatan) {
      return [
        'error' => [
          'kelurahan_id' => ['Kelurahan tersebut bukan bagian dari kecamatan yang dikirim.'],
        ],
      ];
    }

    return [
      // Nama kota disimpan seragam supaya rekap wilayah tidak terpecah
      // gara-gara beda penulisan ("samarinda", "Kota Samarinda", dst).
      'kabkota_id' => 'Samarinda',
      'kecamatan_id' => $kecamatan,
      'kelurahan_id' => $kelurahan,
    ];
  }

  /** Kecamatan Samarinda tersimpan sebagai id; luar Samarinda sudah berupa nama. */
  private function namaKecamatan(?string $nilai): ?string
  {
    return $nilai === null ? null : (optional(Kecamatan::find($nilai))->nama ?? $nilai);
  }

  private function namaKelurahan(?string $nilai): ?string
  {
    return $nilai === null ? null : (optional(Kelurahan::find($nilai))->nama ?? $nilai);
  }

  /** Notifikasi ke admin; kegagalan kirim tidak boleh membatalkan pesanan. */
  private function kirimNotifikasiAdmin(Silalad $pesanan): void
  {
    try {
      Mail::raw(
        "Pendaftaran baru SILALAD (via API) dari: {$pesanan->nama_pelanggan},\n" .
          "No: {$pesanan->nomor_telepon_pelanggan},\n" .
          "Alamat: {$pesanan->alamat},\n" .
          "Kode booking: {$pesanan->kode_booking}",
        function ($msg) {
          $msg->to('pipaair1605@gmail.com')->subject('Pendaftaran Baru SILALAD');
        }
      );
    } catch (\Exception $e) {
      Log::error('Gagal kirim email pesanan SILALAD dari API: ' . $e->getMessage());
    }
  }
}
