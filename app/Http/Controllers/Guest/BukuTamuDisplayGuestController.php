<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;

class BukuTamuDisplayGuestController extends Controller
{
    public function index(Request $request)
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Display Buku Tamu";

        return view('guest.pages.buku-tamu.display.index', [
            'meta_description' => $meta_description,
            'page_title' => $page_title,
        ]);
    }

    // Endpoint untuk AJAX polling antrean buku tamu
    public function queueData(Request $request)
    {
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $id_kepala_dinas = 1;
        $id_sekretariat = 2;
        $allBagian = SusunanOrganisasi::where('id_susunan_organisasi_parent', 1)
            ->where('id_susunan_organisasi', '!=', $id_kepala_dinas)
            ->select('id_susunan_organisasi', 'nama_susunan_organisasi')
            ->orderBy('nama_susunan_organisasi')
            ->get();

        // Pisahkan Sekretariat dan bagian lain
        $sekretariat = $allBagian->firstWhere('id_susunan_organisasi', $id_sekretariat);
        $bagianLain = $allBagian->filter(function($item) use ($id_sekretariat) {
            return $item->id_susunan_organisasi != $id_sekretariat;
        });

        $result = [];

        // Sekretariat di atas
        if ($sekretariat) {
            $antrean = $sekretariat->bukuTamu()
                ->whereIn('status', ['Pending', 'Diterima'])
                ->orderBy('created_at', 'asc')
                ->first();

            $kode = $antrean ? substr($antrean->id_buku_tamu, -4) : null;
            $created_at = '';
            if ($antrean && $antrean->created_at) {
                $dt = $antrean->created_at;
                $bulan = $bulanIndo[(int)$dt->format('n')];
                $created_at = $dt->format('j') . ' ' . $bulan . ' ' . $dt->format('Y') . ' (' . $dt->format('H.i') . ')';
            }

            $result[] = [
                'bagian' => $sekretariat->nama_susunan_organisasi,
                'kode' => $kode,
                'created_at' => $created_at,
            ];
        }

        // Bagian lain
        foreach ($bagianLain as $bagian) {
            $antrean = $bagian->bukuTamu()
                ->whereIn('status', ['Pending', 'Diterima'])
                ->orderBy('created_at', 'asc')
                ->first();

            $kode = $antrean ? substr($antrean->id_buku_tamu, -4) : null;
            $created_at = '';
            if ($antrean && $antrean->created_at) {
                $dt = $antrean->created_at;
                $bulan = $bulanIndo[(int)$dt->format('n')];
                $created_at = $dt->format('j') . ' ' . $bulan . ' ' . $dt->format('Y') . ' (' . $dt->format('H.i') . ')';
            }

            $result[] = [
                'bagian' => $bagian->nama_susunan_organisasi,
                'kode' => $kode,
                'created_at' => $created_at,
            ];
        }

        return response()->json(['data' => $result]);
    }
}
