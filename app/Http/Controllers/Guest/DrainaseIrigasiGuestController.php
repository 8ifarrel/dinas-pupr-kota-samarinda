<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\DrainaseIrigasiPelapor;
use App\Models\DrainaseIrigasiLaporan;
use App\Models\DrainaseIrigasiLaporanFoto;
use App\Models\DrainaseIrigasiLaporanTindakLanjut;
use App\Models\SKM;

class DrainaseIrigasiGuestController extends Controller
{
	public string $page_context = 'Drainase dan Irigasi';
	public int $layanan_id = 5;
	public int $struktur_organisasi_id = 10; 

	public function index()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Layanan Umum";
		$page_title = "Pelaporan Saluran Drainase dan Irigasi";

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

	public function create()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Layanan Umum";
		$page_title = "Buat Laporan Saluran Drainase dan Irigasi";

		$kecamatan = Kecamatan::orderBy('nama')->get();
		$kelurahan = Kelurahan::orderBy('nama')->get();

		return view('guest.pages.drainase-irigasi.create', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
			'kecamatan' => $kecamatan,
			'kelurahan' => $kelurahan,
		]);
	}

	public function store(Request $request)
	{
		$messages = [
			'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
			'pekerjaan.required' => 'Pekerjaan wajib diisi.',
			'alamat.required' => 'Alamat wajib diisi.',
			'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
			'nomor_telepon.regex' => 'Nomor telepon harus diawali 08 dan terdiri dari 10-15 digit.',
			'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
			'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
			'nama_jalan.required' => 'Nama jalan wajib diisi.',
			'longitude.required' => 'Longitude wajib diisi.',
			'longitude.regex' => 'Format longitude tidak valid.',
			'latitude.required' => 'Latitude wajib diisi.',
			'latitude.regex' => 'Format latitude tidak valid.',
			'detail_lokasi.required' => 'Detail lokasi wajib diisi.',
			'deskripsi_pengaduan.required' => 'Deskripsi pengaduan wajib diisi.',
			'laporan__foto_input.*.required' => 'Minimal 1 foto kerusakan harus diunggah.',
			'laporan__foto_input.*.image' => 'File harus berupa gambar JPG, JPEG, atau PNG.',
			'laporan__foto_input.*.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
			'laporan__foto_input.*.max' => 'Ukuran foto maksimal 2MB.',
			'skm__rating.required' => 'Rating wajib dipilih.',
			'skm__kritik.required' => 'Kritik wajib diisi.',
			'skm__saran.required' => 'Saran wajib diisi.',
			'bordered-checkbox.required' => 'Anda harus menyetujui pernyataan.',
		];

		$validated = $request->validate([
			'nama_lengkap' => 'required|string|max:100',
			'pekerjaan' => 'required|string|max:50',
			'alamat' => 'required|string',
			'nomor_telepon' => 'required|regex:/^08[0-9]{8,13}$/',
			'kecamatan_id' => 'required|exists:kecamatan,id',
			'kelurahan_id' => 'required|exists:kelurahan,id',
			'nama_jalan' => 'required|string|max:150',
			'longitude' => ['required', 'regex:/^[-+]?\d{1,3}\.\d{7}$/'],
			'latitude' => ['required', 'regex:/^[-+]?\d{1,3}\.\d{7}$/'],
			'detail_lokasi' => 'required|string',
			'deskripsi_pengaduan' => 'required|string',
			'laporan__foto_input' => 'required',
			'laporan__foto_input.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
			'skm__rating' => 'required|integer|min:1|max:4',
			'skm__kritik' => 'required|string',
			'skm__saran' => 'required|string',
			'bordered-checkbox' => 'required',
		], $messages);

		// Simpan pelapor
		$pelapor = DrainaseIrigasiPelapor::create([
			'nama_lengkap' => $validated['nama_lengkap'],
			'pekerjaan' => $validated['pekerjaan'],
			'alamat' => $validated['alamat'],
			'nomor_telepon' => $validated['nomor_telepon'],
		]);

		// Simpan laporan
		$laporan = DrainaseIrigasiLaporan::create([
			'pelapor_id' => $pelapor->id,
			'nama_jalan' => $validated['nama_jalan'],
			'kecamatan_id' => $validated['kecamatan_id'],
			'kelurahan_id' => $validated['kelurahan_id'],
			'longitude' => $validated['longitude'],
			'latitude' => $validated['latitude'],
			'detail_lokasi' => $validated['detail_lokasi'],
			'deskripsi_pengaduan' => $validated['deskripsi_pengaduan'],
		]);

		// Buat tindak lanjut otomatis dengan status pending
		DrainaseIrigasiLaporanTindakLanjut::create([
			'laporan_id' => $laporan->id,
			'status' => 'pending',
			'deskripsi' => 'Laporan telah masuk. Mohon menunggu proses lebih lanjut',
			'jenis' => 'belum_diklasifikasikan',
		]);

		// Simpan foto laporan (multi)
		if ($request->hasFile('laporan__foto_input')) {
			$files = $request->file('laporan__foto_input');
			$i = 1;
			foreach ($files as $file) {
				if (!$file || !$file->isValid()) continue;
				$ext = $file->getClientOriginalExtension();
				$now = now();
				$namaFoto = "foto{$i}_" . $now->format('HisdmY') . ".{$ext}";
				$path = "drainase-irigasi/{$laporan->id}/foto_laporan/{$namaFoto}";
				$file->storeAs("public/drainase-irigasi/{$laporan->id}/foto_laporan", $namaFoto);
				DrainaseIrigasiLaporanFoto::create([
					'laporan_id' => $laporan->id,
					'foto' => $path,
				]);
				$i++;
			}
		}

		// Simpan SKM
		$skm = SKM::create([
			'nilai' => $validated['skm__rating'],
			'ip_address' => $request->ip(),
			'kritik' => $validated['skm__kritik'],
			'saran' => $validated['skm__saran'],
			'layanan_id' => $this->layanan_id,
		]);
		// Update pelapor dengan skm_id
		$pelapor->skm_id = $skm->id;
		$pelapor->save();

		return redirect()->route('guest.drainase-irigasi.index')->with('success', 'Laporan berhasil dikirim. Mohon menunggu proses lebih lanjut.');
	}

	public function show(Request $request)
	{
		$meta_description = "Detail laporan saluran drainase dan irigasi.";
		$page_subtitle = "Detail Laporan";
		$page_title = "Laporan Saluran Drainase dan Irigasi";

		// Get latest status for each laporan
		$latestTindakLanjutIds = DB::table('drainase_irigasi_laporan_tindak_lanjut')
			->select(DB::raw('MAX(id) as id'))
			->groupBy('laporan_id');

		// Query to get all reports with their latest status
		$query = DrainaseIrigasiLaporan::with(['pelapor', 'kecamatan', 'kelurahan'])
			->withTrashed()
			->leftJoin('drainase_irigasi_laporan_tindak_lanjut as tl', function ($join) use ($latestTindakLanjutIds) {
				$join->on('tl.laporan_id', '=', 'drainase_irigasi_laporan.id')
					->whereIn('tl.id', $latestTindakLanjutIds);
			})
			->select('drainase_irigasi_laporan.*', 'tl.status', 'tl.deskripsi', 'tl.jenis');

		// Apply search filters if provided
		if ($request->filled('search_query')) {
			$searchQuery = $request->input('search_query');
			$query->where(function ($q) use ($searchQuery) {
				$q->where('drainase_irigasi_laporan.id', 'LIKE', "%$searchQuery%")
				  ->orWhere('nama_jalan', 'LIKE', "%$searchQuery%");
			});
		}

		if ($request->filled('status_filter')) {
			$statusFilter = $request->input('status_filter');
			$query->where('tl.status', $statusFilter);
		}

		if ($request->filled('jenis_filter')) {
			$jenisFilter = $request->input('jenis_filter');
			$query->where('tl.jenis', $jenisFilter);
		}

		// Sort options (default to latest)
		$sortOption = $request->input('sort', 'latest');
		if ($sortOption === 'oldest') {
			$query->orderBy('drainase_irigasi_laporan.created_at', 'asc');
		} elseif ($sortOption === 'az') {
			$query->orderBy('nama_jalan', 'asc');
		} else { // default: latest
			$query->orderBy('drainase_irigasi_laporan.created_at', 'desc');
		}

		// Paginate results
		$laporan = $query->paginate(10);
		
		// Generate pagination links with query parameters
		$laporan->appends($request->query());

		return view('guest.pages.drainase-irigasi.show', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
			'laporan' => $laporan,
			'search_query' => $request->input('search_query', ''),
			'status_filter' => $request->input('status_filter', ''),
			'jenis_filter' => $request->input('jenis_filter', ''),
			'sort_option' => $sortOption,
		]);
	}
	
	public function detail($id)
	{
		$meta_description = "Detail pengaduan saluran drainase dan irigasi.";
		$page_subtitle = "Detail Pengaduan";
		$page_title = "Detail Pengaduan Drainase dan Irigasi";
		
		// Get the laporan by ID
		$laporan = DrainaseIrigasiLaporan::with(['pelapor', 'kecamatan', 'kelurahan', 'foto'])->findOrFail($id);
		
		// Get all tindak lanjut for this laporan
		$tindakLanjut = DB::table('drainase_irigasi_laporan_tindak_lanjut')
			->where('laporan_id', $id)
			->orderBy('created_at', 'desc')
			->get();
			
		return view('guest.pages.drainase-irigasi.detail', [
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
			'laporan' => $laporan,
			'tindak_lanjut' => $tindakLanjut
		]);
	}
}

