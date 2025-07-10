<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SKM;

class SKMGuestController extends Controller
{
	public function index()
	{
		$meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
		$page_title = "Survei Kepuasan Masyarakat";

		$total_responden = SKM::count();
		$total_nilai = SKM::sum('nilai');
		$rata_rata = $total_responden > 0 ? round($total_nilai / $total_responden, 3) : 0;

		return view('guest.pages.skm.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'total_responden' => $total_responden,
			'rata_rata' => $rata_rata,
		]);
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'nilai' => 'required|integer|min:1|max:4',
		]);

		SKM::create([
			'nilai' => $validated['nilai'],
			'ip_address' => $request->ip(),
		]);

		return redirect()->back()->with('success', 'Terima kasih atas partisipasi Anda!');
	}
}

