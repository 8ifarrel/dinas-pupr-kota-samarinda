<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SejarahDinasPUPRKotaSamarinda;
use Illuminate\Http\Request;

class SejarahDinasPUPRKotaSamarindaAdminController extends Controller
{
	public function index()
	{
		$page_title = "Sejarah";
		$page_description = "Menampilkan sejarah berdirinya dan perkembangan Dinas PUPR Kota Samarinda.";


		$sejarah_dinas_pupr_kota_samarinda = SejarahDinasPUPRKotaSamarinda::select(
			'deskripsi_sejarah_dinas_pupr_kota_samarinda'
		)->first();

		return view('admin.pages.profil.sejarah-dinas-pupr-kota-samarinda.index', [
			'page_title' => $page_title,
			'page_description' => $page_description,
			'sejarah_dinas_pupr_kota_samarinda' => $sejarah_dinas_pupr_kota_samarinda
		]);
	}

	public function edit()
	{
		$page_title = "Edit Sejarah Dinas PUPR Kota Samarinda";
		$page_description = "Perbarui narasi sejarah dan informasi penting terkait perjalanan Dinas PUPR Kota Samarinda.";

		$sejarah = SejarahDinasPUPRKotaSamarinda::first();

		return view('admin.pages.profil.sejarah-dinas-pupr-kota-samarinda.edit', [
			'page_title' => $page_title,
			'page_description' => $page_description,
			'sejarah' => $sejarah
		]);
	}

	public function update(Request $request)
	{
		$request->validate([
			'deskripsi_sejarah_dinas_pupr_kota_samarinda' => 'required|string'
		]);

		$sejarah = SejarahDinasPUPRKotaSamarinda::first();
		if ($sejarah) {
			$sejarah->update([
				'deskripsi_sejarah_dinas_pupr_kota_samarinda' => $request->deskripsi_sejarah_dinas_pupr_kota_samarinda
			]);
		}

		return redirect()->route('admin.profil.sejarah-dinas-pupr-kota-samarinda.index')
			->with('success', 'Sejarah berhasil diperbarui.');
	}
}
