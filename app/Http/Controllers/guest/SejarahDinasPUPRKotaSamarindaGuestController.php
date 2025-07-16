<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\SejarahDinasPUPRKotaSamarinda;

class SejarahDinasPUPRKotaSamarindaGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Profil";
		$page_title = "Sejarah";

		$sejarah_dinas_pupr_kota_samarinda = SejarahDinasPUPRKotaSamarinda::select(
			'deskripsi_sejarah_dinas_pupr_kota_samarinda'
		)->first();

		return view('guest.pages.profil.sejarah-dinas-pupr-kota-samarinda.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'sejarah_dinas_pupr_kota_samarinda' => $sejarah_dinas_pupr_kota_samarinda
		]);
	}
}
