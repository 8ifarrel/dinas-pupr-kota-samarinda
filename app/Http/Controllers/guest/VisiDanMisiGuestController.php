<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Visi;
use App\Models\Misi;

class VisiDanMisiGuestController extends Controller
{
    public function index()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Profil";
        $page_subtitle = "Visi dan Misi";

        $visi = Visi::select(
            'deskripsi_visi',
            'periode_mulai',
            'periode_selesai'
        )->first();

        $misi = Misi::select(
            'deskripsi_misi',
            'periode_mulai',
            'periode_selesai'
        )->orderBy('nomor_urut')->get();

        return view('guest.pages.profil.visi-dan-misi.index', [
            'meta_description' => $meta_description,
            'page_title' => $page_title,
            'page_subtitle' => $page_subtitle,
            'visi' => $visi,
            'misi' => $misi 
        ]);
    }
}

