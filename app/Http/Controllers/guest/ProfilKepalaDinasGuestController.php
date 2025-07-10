<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\KepalaDinas;
use App\Models\KepalaDinasRiwayatPendidikan;
use App\Models\KepalaDinasJenjangKarir;

class ProfilKepalaDinasGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Profil";
		$page_subtitle = "Profil Kepala Dinas";

		$kepala_dinas = KepalaDinas::with('susunanOrganisasi')
			->where('id_susunan_organisasi', 1)
			->first();

		$riwayat_pendidikan = KepalaDinasRiwayatPendidikan::orderBy('tanggal_masuk', 'desc')
			->get();

		$jenjang_karir = KepalaDinasJenjangKarir::orderBy('tanggal_masuk', 'desc')
			->get();

		return view('guest.pages.profil.profil-kepala-dinas.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'kepala_dinas' => $kepala_dinas,
			'riwayat_pendidikan' => $riwayat_pendidikan,
			'jenjang_karir' => $jenjang_karir
		]);
	}
}
