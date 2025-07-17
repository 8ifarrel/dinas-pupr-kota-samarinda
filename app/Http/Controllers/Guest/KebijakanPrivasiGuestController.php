<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class KebijakanPrivasiGuestController extends Controller
{
	public string $page_context = 'Kebijakan Privasi';

	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Kebijakan Privasi";

		return view('guest.pages.kebijakan-privasi.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_context' => $this->page_context,
		]);
	}
}
