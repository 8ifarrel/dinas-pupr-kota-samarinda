<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Support\HantuBanyuStatistik;
use Illuminate\Support\Facades\Auth;

class DrainaseIrigasiGuestController extends Controller
{
	public string $page_context = 'Drainase dan Irigasi';

	public function index()
	{
		// Setiap akun kelurahan hanya melihat statistik laporan di kelurahannya.
		$kelurahanId = optional(Auth::guard('kelurahan')->user())->kelurahan_id;

		return view('guest.pages.drainase-irigasi.index', array_merge(
			HantuBanyuStatistik::compute($kelurahanId),
			[
				'meta_description' => 'Laporkan masalah banjir dan kerusakan saluran drainase dan irigasi melalui layanan Hantu Banyu Dinas PUPR Kota Samarinda.',
				'page_title' => 'Hantu Banyu',
				'page_subtitle' => 'Layanan Umum',
				'page_context' => $this->page_context,
			]
		));
	}
}
