<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuTamu;

class BukuTamuAdminController extends Controller
{
	public function index()
	{
		$bukuTamu = BukuTamu::with('susunanOrganisasi')->orderBy('created_at', 'desc')->get();
		$page_title = "Kelola Buku Tamu";
		$page_description = "Lihat dan kelola tamu yang ingin berkunjung ke Dinas PUPR Kota Samarinda";

		return view('admin.pages.buku-tamu.index', [
			'page_title' => $page_title,
			'page_description' => $page_description,
			'bukuTamu' => $bukuTamu,
		]);
	}

	public function edit($id)
	{
		$bukuTamu = BukuTamu::findOrFail($id);
		$page_title = "Edit Buku Tamu";
		$page_description = "Kelola status kunjungan secara berkala agar tamu dapat memantau proses pengajuan kunjungannya.";

		return view('admin.pages.buku-tamu.edit', [
			'page_title' => $page_title,
			'page_description' => $page_description,
			'bukuTamu' => $bukuTamu,
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'status' => 'required|string',
			'deskripsi_status' => 'nullable|string',
		]);

		$bukuTamu = BukuTamu::findOrFail($id);
		$bukuTamu->status = $request->status;
		$bukuTamu->deskripsi_status = $request->deskripsi_status;
		$bukuTamu->save();

		return redirect()->route('admin.buku-tamu.index')
			->with('success', 'Status Buku Tamu berhasil diperbarui.');
	}
}