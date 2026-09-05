<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\HantuBanyuPelapor;
use App\Models\HantuBanyuLaporan;
use App\Models\HantuBanyuLaporanFoto;
use App\Models\HantuBanyuLaporanTindakLanjut;
use App\Models\SKM;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class HantuBanyuPengaduanGuestController extends Controller
{
  public string $page_context = 'Hantu Banyu';
  public int $layanan_id = 5;
  public int $struktur_organisasi_id = 10;

  public function create()
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Layanan Umum";
    $page_title = "Buat Laporan Hantu Banyu";

    // Kecamatan & kelurahan dikunci ke wilayah akun kelurahan yang login.
    $akun = Auth::guard('kelurahan')->user();
    $akun->loadMissing('kelurahan.kecamatan');

    return view('guest.pages.hantu-banyu.pengaduan.create', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'page_context' => $this->page_context,
      'akunKelurahan' => $akun->kelurahan,
      'akunKecamatan' => optional($akun->kelurahan)->kecamatan,
    ]);
  }

  public function store(Request $request)
  {
    $messages = [
      'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
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
      'skm__rating' => 'nullable|integer|min:1|max:4',
      'skm__kritik' => 'nullable|string',
      'skm__saran' => 'nullable|string',
      'bordered-checkbox' => 'required',
    ], $messages);

    // ------------------------------------------------------------------
    // Kunci wilayah: akun kelurahan hanya boleh melaporkan lokasi di
    // dalam kelurahannya sendiri.
    // ------------------------------------------------------------------
    $akun = Auth::guard('kelurahan')->user();
    $akun->loadMissing('kelurahan.kecamatan');
    $kelAkun = $akun->kelurahan;

    if (!$kelAkun) {
      return back()->withInput()
        ->withErrors(['kelurahan_id' => 'Akun Anda belum terhubung ke kelurahan manapun. Hubungi admin.']);
    }

    // Abaikan pilihan dari form, paksa ke wilayah akun.
    $validated['kelurahan_id'] = $kelAkun->id;
    $validated['kecamatan_id'] = $kelAkun->kecamatan_id;

    // Verifikasi titik koordinat lewat reverse-geocode.
    $lokasiValid = $this->koordinatDiKelurahan(
      $validated['latitude'],
      $validated['longitude'],
      $kelAkun->nama,
      optional($kelAkun->kecamatan)->nama ?? ''
    );

    if ($lokasiValid === null) {
      return back()->withInput()->withErrors([
        'koordinat' => 'Lokasi tidak dapat diverifikasi saat ini. Coba beberapa saat lagi atau periksa koneksi.',
      ]);
    }

    if (!$lokasiValid) {
      return back()->withInput()->withErrors([
        'koordinat' => 'Titik lokasi berada di luar Kelurahan ' . $kelAkun->nama
          . '. Anda hanya dapat melaporkan lokasi yang berada di dalam kelurahan Anda.',
      ]);
    }

    // Simpan pelapor (asal kelurahan mengikuti akun kelurahan yang login)
    $pelapor = HantuBanyuPelapor::create([
      'nama_lengkap' => $validated['nama_lengkap'],
      'kelurahan_asal_id' => $kelAkun->id,
      'alamat' => $validated['alamat'],
      'nomor_telepon' => $validated['nomor_telepon'],
    ]);

    // Simpan laporan
    $laporan = HantuBanyuLaporan::create([
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
    HantuBanyuLaporanTindakLanjut::create([
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
        $path = "hantu-banyu/{$laporan->id}/foto_laporan/{$namaFoto}";
        $file->storeAs("public/hantu-banyu/{$laporan->id}/foto_laporan", $namaFoto);
        HantuBanyuLaporanFoto::create([
          'laporan_id' => $laporan->id,
          'foto' => $path,
        ]);
        $i++;
      }
    }

    // Simpan SKM (rating, kritik, saran bersifat opsional)
    $skmKritik = trim((string) ($validated['skm__kritik'] ?? '')) ?: null;
    $skmSaran = trim((string) ($validated['skm__saran'] ?? '')) ?: null;
    $skm = SKM::create([
      'nilai' => $validated['skm__rating'] ?? null,
      'ip_address' => $request->ip(),
      'kritik' => $skmKritik,
      'saran' => $skmSaran,
      'layanan_id' => $this->layanan_id,
    ]);
    // Update pelapor dengan skm_id
    $pelapor->skm_id = $skm->id;
    $pelapor->save();

    // Generate the signed URL for the result page
    $url = URL::temporarySignedRoute(
      'guest.hantu-banyu.pengaduan.result',
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
    $latestTindakLanjutIds = DB::table('hantu_banyu_laporan_tindak_lanjut')
      ->select(DB::raw('MAX(id) as id'))
      ->groupBy('laporan_id');

    // Setiap akun kelurahan hanya melihat laporan di kelurahannya.
    $kelurahanId = optional(Auth::guard('kelurahan')->user())->kelurahan_id;

    // Query to get all reports with their latest status.
    // Laporan yang terhapus sengaja TIDAK ditampilkan di sini. Admin pun tidak
    // melihat data terhapus pada daftar e-panel, jadi keduanya harus sepakat:
    // bila publik ikut menampilkannya, akan lahir keadaan ganjil di mana warga
    // masih melihat sebuah laporan sementara admin tidak bisa menanganinya.
    $query = HantuBanyuLaporan::with(['pelapor', 'kecamatan', 'kelurahan'])
      ->when($kelurahanId, fn($q) => $q->where('hantu_banyu_laporan.kelurahan_id', $kelurahanId))
      ->leftJoin('hantu_banyu_laporan_tindak_lanjut as tl', function ($join) use ($latestTindakLanjutIds) {
        $join->on('tl.laporan_id', '=', 'hantu_banyu_laporan.id')
          ->whereIn('tl.id', $latestTindakLanjutIds);
      })
      ->select('hantu_banyu_laporan.*', 'tl.status', 'tl.deskripsi', 'tl.jenis');

    // Apply search filters if provided
    if ($request->filled('search_query')) {
      $searchQuery = $request->input('search_query');
      $query->where(function ($q) use ($searchQuery) {
        $q->where('hantu_banyu_laporan.id', 'LIKE', "%$searchQuery%")
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
      $query->orderBy('hantu_banyu_laporan.created_at', 'asc');
    } elseif ($sortOption === 'az') {
      $query->orderBy('nama_jalan', 'asc');
    } else { // default: latest
      $query->orderBy('hantu_banyu_laporan.created_at', 'desc');
    }

    // Paginate results
    $laporan = $query->paginate(10);

    // Generate pagination links with query parameters
    $laporan->appends($request->query());

    return view('guest.pages.hantu-banyu.pengaduan.index', [
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
    $laporan = HantuBanyuLaporan::with([
      'pelapor',
      'kecamatan',
      'kelurahan',
      'foto',
      'tindakLanjut' => function ($q) {
        $q->orderBy('created_at', 'desc');
      },
      'tindakLanjut.foto'
      // Sejalan dengan index(): laporan terhapus tidak dibuka untuk publik.
    ])->findOrFail($id);

    // Akun kelurahan hanya boleh membuka laporan di kelurahannya.
    $kelurahanId = optional(Auth::guard('kelurahan')->user())->kelurahan_id;
    abort_unless(!$kelurahanId || (int) $laporan->kelurahan_id === (int) $kelurahanId, 404);

    $page_title = "Detail Pengaduan Hantu Banyu";
    $page_subtitle = "Detail Laporan Hantu Banyu";
    $meta_description = "Detail laporan pengaduan Hantu Banyu Kota Samarinda";

    return view('guest.pages.hantu-banyu.pengaduan.show', [
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
    $laporan = HantuBanyuLaporan::with([
      'pelapor.kelurahanAsal',
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
    $show_url = route('guest.hantu-banyu.pengaduan.show', ['id' => $laporan->id]);

    // Asal kelurahan pelapor (mengikuti akun kelurahan saat laporan dibuat)
    $kelurahan_akun = optional($laporan->pelapor->kelurahanAsal)->nama ?? '-';

    // Render the PDF view
    $html = view('guest.pages.hantu-banyu.pengaduan.pdf', [
      'laporan' => $laporan,
      'tanggal_laporan' => $tanggal_laporan,
      'waktu_laporan' => $waktu_laporan,
      'show_url' => $show_url,
      'kelurahan_akun' => $kelurahan_akun,
    ])->render();

    // Generate PDF filename
    $filename = '[Hantu Banyu] Bukti Pengaduan Nomor ' . $laporan->id . '.pdf';

    try {
      // Create the temp directory if it doesn't exist
      $tempDir = storage_path('app/temp');
      if (!File::exists($tempDir)) {
        File::makeDirectory($tempDir, 0755, true);
      }

      $pdfPath = $tempDir . DIRECTORY_SEPARATOR . $filename;

      $browsershot = Browsershot::html($html);

      // Di Windows path Node/npm perlu ditunjuk lewat .env; di Linux dibiarkan
      // kosong agar Browsershot mendeteksinya sendiri dari PATH.
      if ($nodeBinary = config('services.browsershot.node_binary')) {
        $browsershot->setNodeBinary($nodeBinary);
      }
      if ($npmBinary = config('services.browsershot.npm_binary')) {
        $browsershot->setNpmBinary($npmBinary);
      }

      $browsershot
        ->waitUntilNetworkIdle()
        ->format('A4')
        ->margins(10, 10, 10, 10)
        ->showBackground(true) // Enable background graphics
        ->savePdf($pdfPath);

      // Return the PDF as a download
      return response()->download($pdfPath, $filename, [
        'Content-Type' => 'application/pdf',
      ])->deleteFileAfterSend(true);
      // Ditangkap sebagai Throwable, bukan Exception saja. Kegagalan pada
      // pembuatan PDF bisa berupa Error PHP (mis. kelas Browsershot belum
      // terpasang), dan Error bukan turunan Exception - bila hanya Exception
      // yang ditangkap, kegagalan itu lolos menjadi halaman 500 berisi rincian
      // teknis di hadapan warga.
    } catch (\Throwable $e) {
      Log::error('PDF Generation Error: ' . $e->getMessage());
      Log::error('Error Stack Trace: ' . $e->getTraceAsString());

      return back()->with('error', 'Bukti pengaduan gagal dibuat. Silakan coba lagi beberapa saat lagi.');
    }
  }

  /**
   * Apakah koordinat berada di dalam kelurahan tersebut?
   *
   * @return bool|null true/false bila terverifikasi; null bila geocoder tidak
   *                   dapat dihubungi, sehingga pemanggil bisa membedakan
   *                   "lokasi salah" dari "belum bisa diperiksa".
   */
  private function koordinatDiKelurahan($lat, $lon, string $namaKelurahan, string $namaKecamatan = ''): ?bool
  {
    $alamat = $this->reverseGeocode($lat, $lon);

    if ($alamat === null) {
      return null;
    }

    $kelurahanGeo = $alamat['village'] ?? $alamat['neighbourhood'] ?? $alamat['hamlet'] ?? '';
    $kecamatanGeo = $alamat['city_district'] ?? $alamat['municipality'] ?? $alamat['county'] ?? $alamat['suburb'] ?? '';

    if ($kelurahanGeo !== '') {
      return $this->namaCocok($kelurahanGeo, $namaKelurahan);
    }

    if ($kecamatanGeo !== '') {
      return $this->namaCocok($kecamatanGeo, $namaKecamatan);
    }

    return false;
  }

  /**
   * Reverse-geocode koordinat menjadi array "address" dari Nominatim,
   * atau null bila gagal.
   */
  private function reverseGeocode($lat, $lon): ?array
  {
    try {
      $res = Http::withHeaders([
        'User-Agent' => 'dinas-pupr-kota-samarinda/1.0 (hantu-banyu)',
      ])->timeout(8)->get('https://nominatim.openstreetmap.org/reverse', [
        'format' => 'jsonv2',
        'lat' => $lat,
        'lon' => $lon,
        'addressdetails' => 1,
        'accept-language' => 'id',
      ]);

      if (!$res->ok()) {
        return null;
      }

      $alamat = $res->json('address');

      return is_array($alamat) ? $alamat : null;
    } catch (\Throwable $e) {
      Log::warning('Hantu Banyu reverse-geocode gagal: ' . $e->getMessage());

      return null;
    }
  }

  /**
   * Bandingkan nama wilayah dari geocoder dengan nama wilayah di basis data.
   * Toleran terhadap variasi penulisan (mis. "Sei/Sungai Dama",
   * "Simpang Tiga (Loa Janan Ilir)").
   */
  private function namaCocok(string $dariGeocoder, string $dariDb): bool
  {
    if ($dariGeocoder === '' || $dariDb === '') {
      return false;
    }

    $a = $this->variasiNama($dariGeocoder);
    $b = $this->variasiNama($dariDb);

    foreach ($a as $x) {
      foreach ($b as $y) {
        if ($x === $y) {
          return true;
        }
        if (strlen($x) >= 4 && strlen($y) >= 4 && (str_contains($x, $y) || str_contains($y, $x))) {
          return true;
        }
      }
    }

    return false;
  }

  /**
   * Pecah sebuah nama wilayah menjadi beberapa varian ternormalisasi
   * (huruf kecil, tanpa spasi/tanda baca, "sei" -> "sungai").
   *
   * @return array<int,string>
   */
  private function variasiNama(string $nama): array
  {
    $nama = strtolower(trim($nama));
    $potongan = preg_split('/[\/()]+/', $nama) ?: [];
    $potongan[] = $nama;

    $hasil = [];
    foreach ($potongan as $p) {
      $p = trim($p);
      $p = preg_replace('/\bsei\b/', 'sungai', $p);
      $p = preg_replace('/^(kelurahan|desa|kecamatan)\s+/', '', $p);
      $p = preg_replace('/[^a-z0-9]+/', '', $p);
      if ($p !== '') {
        $hasil[$p] = true;
      }
    }

    return array_keys($hasil);
  }

  public function result($id, Request $request)
  {
    $laporan = HantuBanyuLaporan::with([
      'pelapor',
      'kecamatan',
      'kelurahan'
    ])->findOrFail($id);

    $meta_description = "Laporan pengaduan drainase dan irigasi berhasil dikirim";
    $page_subtitle = "Hasil Pengaduan";
    $page_title = "Laporan Berhasil Dikirim";

    return view('guest.pages.hantu-banyu.pengaduan.result', [
      'laporan' => $laporan,
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'page_context' => $this->page_context,
    ]);
  }

}