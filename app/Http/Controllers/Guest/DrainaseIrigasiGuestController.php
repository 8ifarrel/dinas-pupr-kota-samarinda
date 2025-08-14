<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrainaseIrigasiGuestController extends Controller
{
	public string $page_context = 'Drainase dan Irigasi';

	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Layanan Umum";
		$page_title = "Hantu Banyu";

		// Ambil data statistik per bulan-tahun
		$periode_bulan = [
			['label' => 'Januari', 'bulan' => 1],
			['label' => 'Februari', 'bulan' => 2],
			['label' => 'Maret', 'bulan' => 3],
			['label' => 'April', 'bulan' => 4],
			['label' => 'Mei', 'bulan' => 5],
			['label' => 'Juni', 'bulan' => 6],
			['label' => 'Juli', 'bulan' => 7],
			['label' => 'Agustus', 'bulan' => 8],
			['label' => 'September', 'bulan' => 9],
			['label' => 'Oktober', 'bulan' => 10],
			['label' => 'November', 'bulan' => 11],
			['label' => 'Desember', 'bulan' => 12],
		];
		$tahun = 2025;

		// Ambil id tindaklanjut terbaru per laporan
		$latestTindakLanjutIds = DB::table('drainase_irigasi_laporan_tindak_lanjut')
			->select(DB::raw('MAX(id) as id'))
			->groupBy('laporan_id');

		// Statistik Laporan Masuk (Bar Chart)
		$statistik_laporan_masuk = [];
		foreach ($periode_bulan as $p) {
			$bulan = $p['bulan'];
			$pending = DB::table('drainase_irigasi_laporan_tindak_lanjut')
				->select(DB::raw('count(*) as jumlah'))
				->whereIn('id', $latestTindakLanjutIds)
				->where('status', 'pending')
				->whereMonth('created_at', $bulan)
				->whereYear('created_at', $tahun)
				->value('jumlah');
			$diproses = DB::table('drainase_irigasi_laporan_tindak_lanjut')
				->select(DB::raw('count(*) as jumlah'))
				->whereIn('id', $latestTindakLanjutIds)
				->whereIn('status', [
					'diterima', 'menunggu_survei', 'sudah_disurvei', 'menunggu_jadwal_pengerjaan', 'sedang_dikerjakan'
				])
				->whereMonth('created_at', $bulan)
				->whereYear('created_at', $tahun)
				->value('jumlah');
			$selesai = DB::table('drainase_irigasi_laporan_tindak_lanjut')
				->select(DB::raw('count(*) as jumlah'))
				->whereIn('id', $latestTindakLanjutIds)
				->where('status', 'selesai')
				->whereMonth('created_at', $bulan)
				->whereYear('created_at', $tahun)
				->value('jumlah');
			$statistik_laporan_masuk[] = [
				'bulan' => $p['label'],
				'pending' => $pending,
				'diproses' => $diproses,
				'selesai' => $selesai,
			];
		}

		// Statistik Laporan Diproses (Doughnut Chart)
		$statistik_laporan_diproses = [];
		foreach ($periode_bulan as $p) {
			$bulan = $p['bulan'];
			$statistik_laporan_diproses[$bulan] = [
				'diterima' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('status', 'diterima')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'menunggu_survei' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('status', 'menunggu_survei')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'sudah_disurvei' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('status', 'sudah_disurvei')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'menunggu_jadwal_pengerjaan' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('status', 'menunggu_jadwal_pengerjaan')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'sedang_dikerjakan' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('status', 'sedang_dikerjakan')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
			];
		}

		// Statistik Jenis Laporan (Doughnut Chart)
		$statistik_jenis_laporan = [];
		foreach ($periode_bulan as $p) {
			$bulan = $p['bulan'];
			$statistik_jenis_laporan[$bulan] = [
				'belum_diklasifikasikan' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('jenis', 'belum_diklasifikasikan')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'darurat' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('jenis', 'darurat')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'biasa' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('jenis', 'biasa')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
				'rutin' => DB::table('drainase_irigasi_laporan_tindak_lanjut')
					->select(DB::raw('count(*) as jumlah'))
					->whereIn('id', $latestTindakLanjutIds)
					->where('jenis', 'rutin')
					->whereMonth('created_at', $bulan)
					->whereYear('created_at', $tahun)
					->value('jumlah'),
			];
		}

		// Total laporan masuk
		$total_laporan_masuk = DB::table('drainase_irigasi_laporan')->count();

		// Total laporan diproses: hanya latest tindaklanjut tiap laporan dengan status proses
		$total_laporan_diproses = DB::table('drainase_irigasi_laporan_tindak_lanjut')
			->whereIn('id', $latestTindakLanjutIds)
			->whereIn('status', [
				'diterima', 'menunggu_survei', 'sudah_disurvei', 'menunggu_jadwal_pengerjaan', 'sedang_dikerjakan'
			])
			->count();

		// Total jenis laporan (jumlah laporan, sama dengan total laporan masuk)
		$total_jenis_laporan = $total_laporan_masuk;

		// Ambil tanggal terakhir update dari laporan
		$tanggal_terakhir_update = DB::table('drainase_irigasi_laporan')
			->max('updated_at');

		$tanggal_terakhir_update_formatted = $tanggal_terakhir_update
			? Carbon::parse($tanggal_terakhir_update)->translatedFormat('d F Y')
			: '-';

		return view('guest.pages.drainase-irigasi.index', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
			'statistik_laporan_masuk' => $statistik_laporan_masuk,
			'statistik_laporan_diproses' => $statistik_laporan_diproses,
			'statistik_jenis_laporan' => $statistik_jenis_laporan,
			'periode_bulan' => $periode_bulan,
			'tahun_statistik' => $tahun,
			'tanggal_terakhir_update' => $tanggal_terakhir_update_formatted,
			'total_laporan_masuk' => $total_laporan_masuk,
			'total_laporan_diproses' => $total_laporan_diproses,
			'total_jenis_laporan' => $total_jenis_laporan,
		]);
	}
}

