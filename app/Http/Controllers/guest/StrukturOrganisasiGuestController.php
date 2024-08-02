<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use App\Models\Jabatan;
use App\Models\StrukturOrganisasiDiagram;

class StrukturOrganisasiGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Profil";
		$page_subtitle = "Struktur Organisasi";

		$struktur_organisasi_diagram = StrukturOrganisasiDiagram::select('diagram_struktur_organisasi')
		->whereNull('id_struktur_organisasi')
		->first();	

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

	public function show($slug_jabatan)
	{
		$struktur_organisasi = StrukturOrganisasi::with(['jabatan.pegawai', 'slider', 'jabatan'])
			->whereHas('jabatan', function ($query) use ($slug_jabatan) {
				$query->where('slug_jabatan', $slug_jabatan);
			})->select(
				'id_struktur_organisasi',
				'id_jabatan'
			)->firstOrFail();


		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Profil";
		$page_subtitle = $struktur_organisasi->jabatan->nama_jabatan;

		return view('guest.pages.profil.struktur-organisasi.show', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'struktur_organisasi' => $struktur_organisasi,
		]);
	}
}
