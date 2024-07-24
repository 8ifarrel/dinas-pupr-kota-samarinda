<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Informasi PUPR";
		$page_subtitle = "Pengumuman";

		$pengumuman = Pengumuman::select(
			"judul_pengumuman",
			"slug_pengumuman",
			"perihal",
			"file_lampiran",
			"created_at",
		)->get();

		return view('guest.pages.pengumuman.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'pengumuman' => $pengumuman,
		]);
	}
}
