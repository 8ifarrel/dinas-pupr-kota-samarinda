<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Slider;
use App\Models\Pegawai;
use App\Models\StrukturOrganisasi;
use App\Models\Partner;

class BerandaGuestController extends Controller
{
    public function index()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Beranda";

        $berita = Berita::with('kategori.jabatan')->select(
            'judul_berita',
            'slug_berita',
            'foto_berita',
            'id_berita_kategori', 
            'created_at',
        )->take(6)->get();

        $slider = Slider::select(
            'foto_slider',
        )->where('is_visible', true)->orderBy('nomor_urut_slider')->get();

        $struktur_organisasi = StrukturOrganisasi::with('jabatan')->select(
            'id_jabatan',
            'ikon_jabatan',
            'nomor_urut_jabatan'
        )->get();

        $kepala_dinas = Pegawai::with('jabatan')->select(
            'id_jabatan',
            'nama_pegawai',
            'foto_pegawai'
        )->whereHas('jabatan', function($query) {
            $query->where('nama_jabatan', 'Kepala Dinas');
        })->first();        

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
