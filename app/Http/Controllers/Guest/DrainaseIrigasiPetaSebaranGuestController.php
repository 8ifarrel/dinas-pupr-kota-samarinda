<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DrainaseIrigasiLaporan;
use Illuminate\Support\Facades\DB;

class DrainaseIrigasiPetaSebaranGuestController extends Controller
{
    public function index(Request $request)
    {
		$meta_description = "Ini deskripsi halaman blablabla lorem";
		$page_subtitle = "Layanan Umum";
		$page_title = "Peta Sebaran Hantu Banyu";

        // Ambil id tindaklanjut terbaru per laporan
        $latestTindakLanjutIds = DB::table('drainase_irigasi_laporan_tindak_lanjut')
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('laporan_id');

        // Query laporan dengan status & jenis terbaru
        $laporan = DrainaseIrigasiLaporan::with([
                'kecamatan', 'kelurahan', 'tindakLanjut' => function($q) {
                    $q->orderBy('created_at', 'desc');
                }
            ])
            ->leftJoin('drainase_irigasi_laporan_tindak_lanjut as tl', function ($join) use ($latestTindakLanjutIds) {
                $join->on('tl.laporan_id', '=', 'drainase_irigasi_laporan.id')
                    ->whereIn('tl.id', $latestTindakLanjutIds);
            })
            ->select(
                'drainase_irigasi_laporan.*',
                'tl.status as status_laporan',
                'tl.jenis as jenis_laporan',
                'tl.deskripsi as deskripsi_status'
            )
            ->get();

        // Untuk filter status unik
        $statusList = DB::table('drainase_irigasi_laporan_tindak_lanjut')
            ->select('status')
            ->distinct()
            ->pluck('status')
            ->toArray();

        return view('guest.pages.drainase-irigasi.peta-sebaran.index', [
            'meta_description' => $meta_description,
            'page_subtitle' => $page_subtitle,
            'page_title' => $page_title,
            'laporan' => $laporan,
            'statusList' => $statusList,
        ]);
    }
}
