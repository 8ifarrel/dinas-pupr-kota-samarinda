<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DrainaseIrigasiGuestController extends Controller
{
	public string $page_context = 'Drainase dan Irigasi';

	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Layanan Umum";
		$page_title = "Pelaporan Saluran Drainase dan Irigasi";

		return view('guest.pages.drainase-irigasi.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
		]);
	}

	public function create()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Layanan Umum";
		$page_title = "Buat Laporan Saluran Drainase dan Irigasi";

		return view('guest.pages.drainase-irigasi.create', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
		]);
	}
}
