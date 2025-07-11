<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Slider;
use App\Models\SusunanOrganisasi; 
use App\Models\StrukturOrganisasi;
use App\Models\Partner;
use App\Models\KepalaDinas;

class BerandaGuestController extends Controller
{
    public function index()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Beranda";

        $berita = Berita::with('kategori.susunanOrganisasi')
            ->select(
                'judul_berita',
                'slug_berita',
                'foto_berita',
                'id_berita_kategori',
                'created_at'
            )
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();


        $slider = Slider::select(
            'foto_slider',
        )->where('is_visible', true)->orderBy('nomor_urut_slider')->get();

        $struktur_organisasi = StrukturOrganisasi::with('susunanOrganisasi')->select(
            'id_susunan_organisasi',
            'ikon_jabatan',
            'nomor_urut_jabatan'
        )->get();

        $kepala_dinas = KepalaDinas::with('susunanOrganisasi')
            ->where('id_susunan_organisasi', 1)
            ->first();

        $partner = Partner::select(
            'nama_partner',
            'foto_partner',
            'url_partner',
        )->get();

        return view('guest.pages.beranda.index', [
            'meta_description' => $meta_description,
            'page_title' => $page_title,
            'berita' => $berita,
            'slider' => $slider,
            'struktur_organisasi' => $struktur_organisasi,
            'partner' => $partner,
            'kepala_dinas' => $kepala_dinas
        ]);
    }
}
