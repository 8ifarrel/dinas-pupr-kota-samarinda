<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use App\Models\Berita; 
use App\Models\BeritaKategori;
use App\Models\StrukturOrganisasiDiagram;

class StrukturOrganisasiGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Profil";
		$page_title = "Struktur Organisasi";

		$struktur_organisasi_diagram = StrukturOrganisasiDiagram::select('diagram_struktur_organisasi')
			->whereNull('id_struktur_organisasi')
			->first();

		$struktur_organisasi = StrukturOrganisasi::with('susunanOrganisasi')->select(
			'id_susunan_organisasi',
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
		$struktur_organisasi = StrukturOrganisasi::with(['susunanOrganisasi', 'slider'])
			->whereHas('susunanOrganisasi', function ($query) use ($slug_jabatan) {
				$query->where('slug_susunan_organisasi', $slug_jabatan);
			})->select(
				'id_struktur_organisasi',
				'id_susunan_organisasi'
			)->firstOrFail();

		$struktur_organisasi_diagram = StrukturOrganisasiDiagram::where(
			'id_struktur_organisasi',
			$struktur_organisasi->id_struktur_organisasi
		)->first();

		$berita_kategori_ids = BeritaKategori::where(
			'id_susunan_organisasi',
			$struktur_organisasi->id_susunan_organisasi
		)->pluck('id_berita_kategori');

		$berita = Berita::with('kategori')
			->whereIn('id_berita_kategori', $berita_kategori_ids)
			->select(
				'judul_berita',
				'slug_berita',
				'foto_berita',
				'id_berita_kategori',
				'created_at'
			)
			->take(3)
			->orderBy('created_at', 'desc')
			->get();

		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Profil";
		$page_subtitle = $struktur_organisasi->susunanOrganisasi->nama_susunan_organisasi;

		return view('guest.pages.profil.struktur-organisasi.show', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'struktur_organisasi' => $struktur_organisasi,
			'struktur_organisasi_diagram' => $struktur_organisasi_diagram,
			'berita' => $berita,	
		]);
	}
}

