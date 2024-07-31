<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class BeritaGuestController extends Controller
{
	public function show($slug_berita)
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Informasi PUPR";

		$berita = Berita::where('slug_berita', $slug_berita)->firstOrFail();

		$berita_lainnya = Berita::select(
			'judul_berita',
			'slug_berita',
			'foto_berita',
			'created_at',
			'views_count'
		)->limit(5)->get();

		return view('guest.pages.berita.show', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'berita' => $berita,
			'berita_lainnya' => $berita_lainnya
		]);
	}
}
