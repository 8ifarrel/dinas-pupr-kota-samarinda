<?php

namespace App\Http\Controllers\Guest;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tupoksi;

class TupoksiGuestController extends Controller
{
    public function index()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_subtitle = "Profil";
        $page_title = "Tugas dan Fungsi";

        $tupoksi = Tupoksi::first();
        return view('guest.pages.profil.tupoksi.index', [
            'meta_description' => $meta_description,
            'page_title' => $page_title,
            'page_subtitle' => $page_subtitle,
            'tupoksi' => $tupoksi,
        ]);
    }
}
