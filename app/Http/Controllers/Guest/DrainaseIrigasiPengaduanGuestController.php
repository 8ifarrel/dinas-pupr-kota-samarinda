<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\DrainaseIrigasiPelapor;
use App\Models\DrainaseIrigasiLaporan;
use App\Models\DrainaseIrigasiLaporanFoto;
use App\Models\DrainaseIrigasiLaporanTindakLanjut;
use App\Models\SKM;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\URL;

class DrainaseIrigasiPengaduanGuestController extends Controller
{
	public string $page_context = 'Drainase dan Irigasi';
	public int $layanan_id = 5;
	public int $struktur_organisasi_id = 10;

	public function create()
	{
		$meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
		$page_subtitle = "Layanan Umum";
		$page_title = "Buat Laporan Hantu Banyu";

		$kecamatan = Kecamatan::orderBy('nama')->get();
		$kelurahan = Kelurahan::orderBy('nama')->get();

		return view('guest.pages.drainase-irigasi.pengaduan.create', [
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
				if (!$file || !$file->isValid())
					continue;
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

		// Generate the signed URL for the result page
		$url = URL::temporarySignedRoute(
			'guest.drainase-irigasi.pengaduan.result',
			now()->addMinutes(15), // URL expires in 15 minutes
			['id' => $laporan->id]
		);

		// Redirect to the signed URL
		return redirect()->to($url)->with('success', 'Laporan berhasil dikirim. Mohon menunggu proses lebih lanjut.');
	}

	public function index(Request $request)
	{
		$meta_description = "Detail laporan Hantu Banyu.";
		$page_subtitle = "Detail Laporan";
		$page_title = "Laporan Hantu Banyu";

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

		return view('guest.pages.drainase-irigasi.pengaduan.index', [
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

	public function show($id)
	{
		$laporan = DrainaseIrigasiLaporan::with([
			'pelapor',
			'kecamatan',
			'kelurahan',
			'foto',
			'tindakLanjut' => function ($q) {
				$q->orderBy('created_at', 'desc');
			},
			'tindakLanjut.foto'
		])->withTrashed()->findOrFail($id);

		$page_title = "Detail Pengaduan Hantu Banyu";
		$page_subtitle = "Detail Laporan Hantu Banyu";
		$meta_description = "Detail laporan pengaduan Hantu Banyu Kota Samarinda";

		return view('guest.pages.drainase-irigasi.pengaduan.show', [
			'laporan' => $laporan,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'meta_description' => $meta_description,
			'page_context' => $this->page_context,
		]);
	}

	public function pdf(Request $request, $id)
	{
		// Fetch the report with related data
		$laporan = DrainaseIrigasiLaporan::with([
			'pelapor',
			'kecamatan',
			'kelurahan',
			'foto',
			'tindakLanjut' => function ($q) {
				$q->orderBy('created_at', 'asc')->limit(1);
			}
		])->findOrFail($id);

		// Get formatted date and time
		$tanggal_laporan = Carbon::parse($laporan->created_at)->format('d F Y');
		$waktu_laporan = Carbon::parse($laporan->created_at)->format('H:i');

		// Generate the report URL for QR code
		$show_url = route('guest.drainase-irigasi.pengaduan.show', ['id' => $laporan->id]);

		// Render the PDF view
		$html = view('guest.pages.drainase-irigasi.pengaduan.pdf', [
			'laporan' => $laporan,
			'tanggal_laporan' => $tanggal_laporan,
			'waktu_laporan' => $waktu_laporan,
			'show_url' => $show_url
		])->render();

		// Generate PDF filename
		$filename = '[Hantu Banyu] Bukti Pengaduan Nomor ' . $laporan->id . '.pdf';

		try {
			// Create the temp directory if it doesn't exist
			$tempDir = storage_path('app/temp');
			if (!File::exists($tempDir)) {
				File::makeDirectory($tempDir, 0755, true);
			}

			// Windows-specific paths
			$nodeBinary = 'C:\Program Files\nodejs\node.exe';
			$npmBinary = 'C:\Program Files\nodejs\npm.cmd';

			// Use backslashes for Windows paths
			$tempHtmlPath = $tempDir . '\\' . uniqid() . '.html';
			$pdfPath = $tempDir . '\\' . $filename;

			// Save HTML to a temporary file
			File::put($tempHtmlPath, $html);

			// Use Browsershot with explicit Windows paths
			Browsershot::html($html)
				->setNodeBinary($nodeBinary)
				->setNpmBinary($npmBinary)
				->waitUntilNetworkIdle()
				->format('A4')
				->margins(10, 10, 10, 10)
				->showBackground(true) // Enable background graphics
				->savePdf($pdfPath);

			// Delete temporary HTML file
			if (File::exists($tempHtmlPath)) {
				File::delete($tempHtmlPath);
			}

			// Return the PDF as a download
			return response()->download($pdfPath, $filename, [
				'Content-Type' => 'application/pdf',
			])->deleteFileAfterSend(true);
		} catch (Exception $e) {
			// Log detailed error for debugging
			Log::error('PDF Generation Error: ' . $e->getMessage());
			Log::error('Error Stack Trace: ' . $e->getTraceAsString());

			// Clean up temporary file if it exists
			if (isset($tempHtmlPath) && File::exists($tempHtmlPath)) {
				File::delete($tempHtmlPath);
			}

			// Return an error response
			return back()->with('error', 'Gagal menghasilkan PDF. Error: ' . $e->getMessage());
		}
	}

	public function result($id, Request $request)
	{
		$laporan = DrainaseIrigasiLaporan::with([
			'pelapor',
			'kecamatan',
			'kelurahan'
		])->findOrFail($id);

		$meta_description = "Laporan pengaduan drainase dan irigasi berhasil dikirim";
		$page_subtitle = "Hasil Pengaduan";
		$page_title = "Laporan Berhasil Dikirim";

		return view('guest.pages.drainase-irigasi.pengaduan.result', [
			'laporan' => $laporan,
			'meta_description' => $meta_description,
			'page_title' => $page_title,
			'page_subtitle' => $page_subtitle,
			'page_context' => $this->page_context,
		]);
	}
}