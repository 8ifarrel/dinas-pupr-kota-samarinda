<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JalanPeduliLaporan;
use App\Models\JalanPeduliStatus;

class JalanPeduliStatistikLaporanGuestController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index(Request $request)
    {
        $page_title = "Jalan Peduli - Statistik Laporan";
        $page_description = "Visualisasi perkembangan laporan jalan";

        // Filter logic
        $type = $request->input('type', 'bulan');
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $query = JalanPeduliLaporan::query();

        if ($type === 'bulan') {
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        } elseif ($type === 'tahun') {
            $query->whereYear('created_at', $year);
        }

        // Statistik
        $total = $query->count();
        $pending = (clone $query)->whereHas('status', function($q){ $q->where('nama_status', 'pending'); })->count();
        $accept = (clone $query)->whereHas('status', function($q){
            $q->whereIn('nama_status', ['belum_dikerjakan','disposisi','telah_disurvei','sedang_dikerjakan','telah_dikerjakan']);
        })->count();
        $disposisi = (clone $query)->whereHas('status', function($q){ $q->where('nama_status', 'disposisi'); })->count();
        $belum_dikerjakan = (clone $query)->whereHas('status', function($q){ $q->where('nama_status', 'belum_dikerjakan'); })->count();
        $sedang_dikerjakan = (clone $query)->whereHas('status', function($q){ $q->where('nama_status', 'sedang_dikerjakan'); })->count();
        $telah_disurvei = (clone $query)->whereHas('status', function($q){ $q->where('nama_status', 'telah_disurvei'); })->count();
        $telah_dikerjakan = (clone $query)->whereHas('status', function($q){ $q->where('nama_status', 'telah_dikerjakan'); })->count();

        // Statistik jenis kerusakan
        $jenisKerusakan = (clone $query)->select('jenis_kerusakan')
            ->groupBy('jenis_kerusakan')
            ->pluck('jenis_kerusakan');
        $jenisKerusakanData = [];
        foreach ($jenisKerusakan as $jenis) {
            $jenisKerusakanData[$jenis] = (clone $query)->where('jenis_kerusakan', $jenis)->count();
        }

        // Statistik tingkat kerusakan
        $tingkatKerusakan = (clone $query)->select('tingkat_kerusakan')
            ->groupBy('tingkat_kerusakan')
            ->pluck('tingkat_kerusakan');
        $tingkatKerusakanData = [];
        foreach ($tingkatKerusakan as $tingkat) {
            $tingkatKerusakanData[$tingkat] = (clone $query)->where('tingkat_kerusakan', $tingkat)->count();
        }

        // AJAX response
        if ($request->has('ajax')) {
            return response()->json([
                'total' => $total,
                'pending' => $pending,
                'accept' => $accept,
                'disposisi' => $disposisi,
                'belum_dikerjakan' => $belum_dikerjakan,
                'sedang_dikerjakan' => $sedang_dikerjakan,
                'telah_disurvei' => $telah_disurvei,
                'telah_dikerjakan' => $telah_dikerjakan,
                'jenisKerusakanData' => $jenisKerusakanData,
                'tingkatKerusakanData' => $tingkatKerusakanData,
            ]);
        }

        $view = $request->is('e-panel/jalan-peduli/*') 
            ? 'admin.pages.jalan-peduli.statistik-laporan.index' 
            : 'guest.pages.jalan-peduli.laporan.StatistikLaporan';

        return view($view, [
            'meta_description' => 'Buat Laporan Jalan Peduli - Layanan pelaporan kerusakan jalan di Kota Samarinda.',
            'page_title' => $page_title,
            'page_description' => $page_description,
            'total' => $total,
            'pending' => $pending,
            'accept' => $accept,
            'disposisi' => $disposisi,
            'belum_dikerjakan' => $belum_dikerjakan,
            'sedang_dikerjakan' => $sedang_dikerjakan,
            'telah_disurvei' => $telah_disurvei,
            'telah_dikerjakan' => $telah_dikerjakan,
            'jenisKerusakanData' => $jenisKerusakanData,
            'tingkatKerusakanData' => $tingkatKerusakanData,
        ]);
    }
}
