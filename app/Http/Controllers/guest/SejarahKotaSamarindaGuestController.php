<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\SejarahKotaSamarinda;

class SejarahKotaSamarindaGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Profil";
		$page_subtitle = "Sejarah Kota Samarinda";

		$sejarah_kota_samarinda = SejarahKotaSamarinda::select(
			'deskripsi_sejarah_kota_samarinda'
		)->first();

		return view('guest.pages.profil.sejarah-kota-samarinda.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'sejarah_kota_samarinda' => $sejarah_kota_samarinda
		]);
	}
}
