<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuTamu;
use App\Models\SusunanOrganisasi;
use App\Mail\BukuTamuEmail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BukuTamuGuestController extends Controller
{
	public string $page_context = 'Buku Tamu';

	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Buku Tamu";

		return view('guest.pages.buku-tamu.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
		]);
	}

	public function create()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Buku Tamu";
		$page_subtitle = "Daftar";

		$id_kepala_dinas = 1;
		$jabatan = SusunanOrganisasi::where('id_susunan_organisasi_parent', 1)
			->where('id_susunan_organisasi', '!=', $id_kepala_dinas)
			->select('id_susunan_organisasi', 'nama_susunan_organisasi')
			->get();

		return view('guest.pages.buku-tamu.create', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'jabatan' => $jabatan,
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'nama_pengunjung' => 'required|string',
			'nomor_telepon' => 'required|string',
			'email' => 'required|email',
			'alamat' => 'required|string',
			'jabatan_yang_dikunjungi' => 'required|exists:susunan_organisasi,id_susunan_organisasi',
			'maksud_dan_tujuan' => 'required|string',
		]);

		$idBukuTamu = now()->format('d-m-Y') . '-' . Str::lower(Str::random(4));

		$bukuTamu = new BukuTamu;
		$bukuTamu->id_buku_tamu = $idBukuTamu;
		$bukuTamu->nama_pengunjung = $request->nama_pengunjung;
		$bukuTamu->nomor_telepon = $request->nomor_telepon;
		$bukuTamu->email = $request->email;
		$bukuTamu->alamat = $request->alamat;
		$bukuTamu->jabatan_yang_dikunjungi = $request->jabatan_yang_dikunjungi;
		$bukuTamu->maksud_dan_tujuan = $request->maksud_dan_tujuan;
		$bukuTamu->status = 'Pending';
		$bukuTamu->save();		

		Mail::to($request->email)->send(new BukuTamuEmail($idBukuTamu, $request->all()));

		return redirect()->route('guest.buku-tamu.result', [
			'id' => $idBukuTamu
		]);
	}

	public function result(Request $request)
	{
		$idBukuTamu = $request->query('id');

		if (!$idBukuTamu) {
			return redirect()->route('guest.buku-tamu.index')->with('error', 'ID tidak ditemukan');
		}

		$bukuTamu = BukuTamu::where('id_buku_tamu', $idBukuTamu)->first();

		if (!$bukuTamu) {
			return redirect()->route('guest.buku-tamu.index')->with('error', 'ID tidak ditemukan');
		}

		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Buku Tamu";

		$url = route('guest.buku-tamu.show', ['id' => $idBukuTamu]);
		$qrcode = QrCode::format('svg')->size(100)->generate($url);

		return view('guest.pages.buku-tamu.result', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'buku_tamu' => $bukuTamu,
			'qrcode' => $qrcode,
		]);
	}

	public function show(Request $request) {
		$idBukuTamu = $request->query('id');

		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_title = "Buku Tamu";

		$buku_tamu = BukuTamu::with('susunanOrganisasi')->where('id_buku_tamu', $idBukuTamu)->first();

		return view('guest.pages.buku-tamu.show', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'buku_tamu'	=> $buku_tamu,
			'page_context' => $this->page_context,
		]);
	}
}

