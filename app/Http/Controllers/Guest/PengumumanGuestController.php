<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Storage;

class PengumumanGuestController extends Controller
{
	public string $page_context = 'Pengumuman';

	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Informasi PUPR";
		$page_title = "Pengumuman";

		$pengumuman = Pengumuman::select(
			"judul_pengumuman",
			"slug_pengumuman",
			"perihal",
			"file_lampiran",
			"created_at",
			'updated_at',
			"views_count",
		)->get();

		return view('guest.pages.pengumuman.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'pengumuman' => $pengumuman,
			'page_context' => $this->page_context,
		]);
	}

	public function store($slug)
	{
		$pengumuman = Pengumuman::where('slug_pengumuman', $slug)->firstOrFail();
		$pengumuman->increment('views_count');
		return response()->json(['success' => true]);
	}

	public function download($slug)
	{
		$pengumuman = Pengumuman::where('slug_pengumuman', $slug)->firstOrFail();

		if (!$pengumuman->file_lampiran || !Storage::disk('public')->exists($pengumuman->file_lampiran)) {
			abort(404, 'File tidak ditemukan');
		}

		$filename = $pengumuman->judul_pengumuman . '.' . pathinfo($pengumuman->file_lampiran, PATHINFO_EXTENSION);

		return Storage::disk('public')->download($pengumuman->file_lampiran, $filename);
	}
}

