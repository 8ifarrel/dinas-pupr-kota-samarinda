<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HantuBanyuLaporan;
use App\Models\UserKelurahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HantuBanyuPetaSebaranGuestController extends Controller
{
  public function index(Request $request)
  {
  $meta_description = "Ini deskripsi halaman blablabla lorem";
  $page_subtitle = "Layanan Umum";
  $page_title = "Peta Sebaran Hantu Banyu";

    // Ambil id tindaklanjut terbaru per laporan
    $latestTindakLanjutIds = DB::table('hantu_banyu_laporan_tindak_lanjut')
      ->select(DB::raw('MAX(id) as id'))
      ->groupBy('laporan_id');

    // Setiap akun kelurahan hanya melihat laporan di kelurahannya.
    // Akun kelurahan hanya melihat sebaran di wilayahnya; admin melihat semua.
    $akunKelurahan = Auth::guard('kelurahan')->user();
    $kelurahanId = $akunKelurahan instanceof UserKelurahan ? (int) $akunKelurahan->kelurahan_id : null;

    // Query laporan dengan status & jenis terbaru
    $laporan = HantuBanyuLaporan::with([
        'kecamatan', 'kelurahan', 'tindakLanjut' => function($q) {
          $q->orderBy('created_at', 'desc');
        }
      ])
      ->when($kelurahanId, fn($q) => $q->where('hantu_banyu_laporan.kelurahan_id', $kelurahanId))
      ->leftJoin('hantu_banyu_laporan_tindak_lanjut as tl', function ($join) use ($latestTindakLanjutIds) {
        $join->on('tl.laporan_id', '=', 'hantu_banyu_laporan.id')
          ->whereIn('tl.id', $latestTindakLanjutIds);
      })
      ->select(
        'hantu_banyu_laporan.*',
        'tl.status as status_laporan',
        'tl.jenis as jenis_laporan',
        'tl.deskripsi as deskripsi_status'
      )
      ->get();

    // `id` internal tidak perlu ikut ke payload peta di sisi peramban -
    // tautan detail memakai `kode`.
    $laporan->makeHidden('id');

    // Untuk filter status unik
    $statusList = DB::table('hantu_banyu_laporan_tindak_lanjut')
      ->select('status')
      ->distinct()
      ->pluck('status')
      ->toArray();

    return view('guest.pages.hantu-banyu.peta-sebaran.index', [
      'meta_description' => $meta_description,
      'page_subtitle' => $page_subtitle,
      'page_title' => $page_title,
      'laporan' => $laporan,
      'statusList' => $statusList,
    ]);
  }
}
