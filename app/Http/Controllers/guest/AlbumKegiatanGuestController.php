<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\AlbumKegiatan;
use Illuminate\Http\Request;

class AlbumKegiatanGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Informasi PUPR";
		$page_subtitle = "Album Kegiatan";

		$album_kegiatan = AlbumKegiatan::with(['fotoKegiatan' => function($q) {
			$q->orderBy('created_at', 'asc');
		}])->get();

		return view('guest.pages.album-kegiatan.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'album_kegiatan' => $album_kegiatan,
		]);
	}

	public function show($slug)
	{
		$album = AlbumKegiatan::where('slug', $slug)
			->with('fotoKegiatan')
			->firstOrFail();

		$album->increment('views_count');

		$meta_description = "Lihat foto-foto kegiatan pada album: " . $album->judul;
		$page_title = "Informasi PUPR";
		$page_subtitle = $album->judul;

		return view('guest.pages.album-kegiatan.show', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'album' => $album,
			'photos' => $album->fotoKegiatan,
		]);
	}
}

