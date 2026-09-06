<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

/**
 * Jejak audit perubahan data untuk super admin.
 *
 * Penyaringan dan halamannya dikerjakan di sisi basis data, tidak memakai
 * DataTables sisi klien seperti halaman admin lain. Alasannya tabel ini terus
 * bertambah seumur hidup aplikasi: memuat seluruh barisnya ke peramban akan
 * berat begitu isinya mencapai puluhan ribu baris.
 */
class LogSuperAdminController extends Controller
{
  private const PER_HALAMAN = 25;

  public function index(Request $request)
  {
    $query = LogAktivitas::query();

    if ($aksi = $request->input('aksi')) {
      $query->where('aksi', $aksi);
    }

    if ($pelakuTipe = $request->input('pelaku_tipe')) {
      $query->where('pelaku_tipe', $pelakuTipe);
    }

    if ($model = $request->input('model')) {
      $query->where('model', $model);
    }

    if ($dari = $request->input('tanggal_dari')) {
      $query->whereDate('created_at', '>=', $dari);
    }

    if ($sampai = $request->input('tanggal_sampai')) {
      $query->whereDate('created_at', '<=', $sampai);
    }

    if ($cari = trim((string) $request->input('cari'))) {
      $query->where(function ($q) use ($cari) {
        $q->where('record_label', 'like', "%{$cari}%")
          ->orWhere('pelaku_nama', 'like', "%{$cari}%")
          ->orWhere('pelaku_username', 'like', "%{$cari}%")
          ->orWhere('record_id', $cari)
          ->orWhere('ip_address', 'like', "%{$cari}%");
      });
    }

    $log = $query->orderByDesc('created_at')
      ->orderByDesc('id')
      ->paginate(self::PER_HALAMAN)
      ->withQueryString();

    return view('admin.pages.super-admin.log.index', [
      'log' => $log,
      'daftar_model' => $this->daftarModel(),
      'ringkasan' => $this->ringkasan(),
      'filter' => $request->only(['aksi', 'pelaku_tipe', 'model', 'tanggal_dari', 'tanggal_sampai', 'cari']),
      'ada_filter' => $this->adaFilter($request),
      'page_title' => 'Log Aktivitas',
      'page_description' => 'Jejak audit seluruh penambahan, perubahan, dan penghapusan data pada sistem.',
    ]);
  }

  public function show($id)
  {
    $item = LogAktivitas::findOrFail($id);

    // Riwayat lain pada record yang sama, supaya perjalanan satu data bisa
    // ditelusuri dari satu tempat tanpa menyaring manual di halaman daftar.
    $riwayatRecord = LogAktivitas::where('model', $item->model)
      ->where('record_id', $item->record_id)
      ->where('id', '!=', $item->id)
      ->orderByDesc('created_at')
      ->limit(20)
      ->get();

    return view('admin.pages.super-admin.log.show', [
      'item' => $item,
      'riwayat_record' => $riwayatRecord,
      'page_title' => 'Detail Log Aktivitas',
      'page_description' => 'Rincian satu baris jejak audit beserta riwayat lain pada data yang sama.',
    ]);
  }

  /** Daftar jenis data yang benar-benar pernah muncul di log, untuk isi dropdown filter. */
  private function daftarModel(): array
  {
    return LogAktivitas::query()
      ->select('model', 'model_label')
      ->distinct()
      ->orderBy('model_label')
      ->pluck('model_label', 'model')
      ->all();
  }

  private function ringkasan(): array
  {
    $hariIni = LogAktivitas::whereDate('created_at', today());

    return [
      'total' => LogAktivitas::count(),
      'hari_ini' => (clone $hariIni)->count(),
      'tambah_hari_ini' => (clone $hariIni)->where('aksi', 'tambah')->count(),
      'ubah_hari_ini' => (clone $hariIni)->where('aksi', 'ubah')->count(),
      'hapus_hari_ini' => (clone $hariIni)->where('aksi', 'hapus')->count(),
    ];
  }

  private function adaFilter(Request $request): bool
  {
    foreach (['aksi', 'pelaku_tipe', 'model', 'tanggal_dari', 'tanggal_sampai', 'cari'] as $kunci) {
      if (trim((string) $request->input($kunci)) !== '') {
        return true;
      }
    }

    return false;
  }
}
