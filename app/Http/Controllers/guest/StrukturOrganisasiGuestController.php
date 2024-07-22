<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;
use App\Models\StrukturOrganisasiDiagram;

class StrukturOrganisasiGuestController extends Controller
{
    public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Profil";
		$page_subtitle = "Struktur Organisasi";

		$struktur_organisasi_diagram = StrukturOrganisasiDiagram::select(
			'diagram_struktur_organisasi'
		)->first();

        $struktur_organisasi = StrukturOrganisasi::with('jabatan')->select(
            'id_jabatan',
            'ikon_jabatan',
            'nomor_urut_jabatan'
        )->get();

		return view('guest.pages.profil.struktur-organisasi.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'struktur_organisasi_diagram' => $struktur_organisasi_diagram,
			'struktur_organisasi' => $struktur_organisasi
		]);
	}
}

