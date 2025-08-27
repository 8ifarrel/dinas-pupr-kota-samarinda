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
        $id_kepala_dinas = 1;
        $id_sekretariat = 2;
        $allBagian = SusunanOrganisasi::where('id_susunan_organisasi_parent', 1)
            ->where('id_susunan_organisasi', '!=', $id_kepala_dinas)
            ->select('id_susunan_organisasi', 'nama_susunan_organisasi')
            ->orderBy('nama_susunan_organisasi')
            ->get();

        $today = now()->format('Y-m-d');

        // Pisahkan Sekretariat dan bagian lain
        $sekretariat = $allBagian->firstWhere('id_susunan_organisasi', $id_sekretariat);
        $bagianLain = $allBagian->filter(function($item) use ($id_sekretariat) {
            return $item->id_susunan_organisasi != $id_sekretariat;
        });

        $result = [];

        // Sekretariat di atas
        if ($sekretariat) {
            $antrean = $sekretariat->bukuTamu()
                ->where('status', 'Diterima')
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'asc')
                ->first();

            $nomor_urut = $antrean ? $antrean->nomor_urut : null;

            $result[] = [
                'bagian' => $sekretariat->nama_susunan_organisasi,
                'nomor_urut' => $nomor_urut,
            ];
        }

        // Bagian lain
        foreach ($bagianLain as $bagian) {
            $antrean = $bagian->bukuTamu()
                ->where('status', 'Diterima')
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'asc')
                ->first();

            $nomor_urut = $antrean ? $antrean->nomor_urut : null;

            $result[] = [
                'bagian' => $bagian->nama_susunan_organisasi,
                'nomor_urut' => $nomor_urut,
            ];
        }

        return response()->json(['data' => $result]);
    }
}
