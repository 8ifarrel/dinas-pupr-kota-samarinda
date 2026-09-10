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
use App\Models\UserKelurahan;
use App\Support\HantuBanyu\VerifikasiKoordinatKelurahan;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class HantuBanyuPengaduanGuestController extends Controller
{
  public string $page_context = 'Hantu Banyu';
  public int $layanan_id = 5;
  public int $struktur_organisasi_id = 10;

  private const TIPE_KELURAHAN = 'kelurahan';
  private const TIPE_ADMIN = 'admin';

  public function create()
  {
    $meta_description = "Temukan semua berita terbaru terkait infrastruktur dan kegiatan dari Dinas PUPR Kota Samarinda.";
    $page_subtitle = "Layanan Umum";
    $page_title = "Buat Laporan Hantu Banyu";

    // Akun kelurahan: kecamatan & kelurahan dikunci ke wilayahnya sendiri.
    // Admin UPTD: bebas memilih, jadi butuh daftar seluruh kelurahan.
    $akun = $this->akunKelurahan();
    $adalahAdmin = !$akun && Auth::guard('web')->check();

    return view('guest.pages.hantu-banyu.pengaduan.create', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'page_subtitle' => $page_subtitle,
      'page_context' => $this->page_context,
      'akunKelurahan' => optional($akun)->kelurahan,
      'akunKecamatan' => optional(optional($akun)->kelurahan)->kecamatan,
      'adalahAdmin' => $adalahAdmin,
      'daftarKelurahan' => $adalahAdmin
        ? Kelurahan::with('kecamatan')->orderBy('nama')->get(['id', 'nama', 'kecamatan_id'])
        : collect(),
    ]);
  }

  /** Akun kelurahan yang login beserta relasi wilayahnya, atau null bila admin. */
  private function akunKelurahan(): ?UserKelurahan
  {
    $akun = Auth::guard('kelurahan')->user();

    if (!$akun instanceof UserKelurahan) {
      return null;
    }

    $akun->loadMissing('kelurahan.kecamatan');

    return $akun;
  }

  /**
   * Kelurahan yang boleh dilihat/diisi akun ini.
   *
   * null berarti TIDAK dibatasi (admin) - jadi pemanggil harus memakai
   * `when($id, ...)` alih-alih menganggap null sebagai "tidak ada wilayah".
   */
  private function kelurahanId(): ?int
  {
    $akun = Auth::guard('kelurahan')->user();

    return $akun instanceof UserKelurahan ? (int) $akun->kelurahan_id : null;
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
      // Kecamatan tidak pernah dipercaya dari form: nilainya selalu ditimpa
      // dari kelurahan yang dipilih. Bagi admin isian ini hanya diisi
      // otomatis oleh JavaScript, jadi tidak layak jadi syarat wajib.
      'kecamatan_id' => (!$this->akunKelurahan() && Auth::guard('web')->check())
        ? 'nullable|exists:kecamatan,id' : 'required|exists:kecamatan,id',
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
    // Wilayah laporan.
    //
    // Akun kelurahan terkunci di kelurahannya sendiri: pilihan apa pun yang
    // dikirim form diabaikan. Admin UPTD boleh melapor atas nama kelurahan
    // mana pun, jadi pilihannya dipakai apa adanya - tapi tetap harus
    // kelurahan yang sungguh ada, dan titik koordinatnya tetap diverifikasi
    // terhadap kelurahan yang dipilih itu.
    // ------------------------------------------------------------------
    $akunKelurahan = $this->akunKelurahan();

    if ($akunKelurahan) {
      $kelSasaran = $akunKelurahan->kelurahan;

      if (!$kelSasaran) {
        return back()->withInput()
          ->withErrors(['kelurahan_id' => 'Akun Anda belum terhubung ke kelurahan manapun. Hubungi admin.']);
      }
    } else {
      $kelSasaran = Kelurahan::with('kecamatan')->find($validated['kelurahan_id']);

      if (!$kelSasaran) {
        return back()->withInput()
          ->withErrors(['kelurahan_id' => 'Kelurahan yang dipilih tidak ditemukan.']);
      }
    }

    $validated['kelurahan_id'] = $kelSasaran->id;
    $validated['kecamatan_id'] = $kelSasaran->kecamatan_id;

    // Verifikasi titik koordinat lewat reverse-geocode.
    $lokasiValid = VerifikasiKoordinatKelurahan::koordinatDiKelurahan(
      $validated['latitude'],
      $validated['longitude'],
      $kelSasaran->nama,
      optional($kelSasaran->kecamatan)->nama ?? ''
    );

    if ($lokasiValid === null) {
      return back()->withInput()->withErrors([
        'koordinat' => 'Lokasi tidak dapat diverifikasi saat ini. Coba beberapa saat lagi atau periksa koneksi.',
      ]);
    }

    if (!$lokasiValid) {
      return back()->withInput()->withErrors([
        'koordinat' => 'Titik lokasi berada di luar Kelurahan ' . $kelSasaran->nama
          . ($akunKelurahan
            ? '. Anda hanya dapat melaporkan lokasi yang berada di dalam kelurahan Anda.'
            : '. Pilih titik yang berada di dalam kelurahan tersebut, atau ganti kelurahannya.'),
      ]);
    }

    // Simpan pelapor (asal kelurahan mengikuti wilayah laporan)
    $pelapor = HantuBanyuPelapor::create([
      'nama_lengkap' => $validated['nama_lengkap'],
      'kelurahan_asal_id' => $kelSasaran->id,
      'alamat' => $validated['alamat'],
      'nomor_telepon' => $validated['nomor_telepon'],
    ]);

    // Simpan laporan
    $laporan = HantuBanyuLaporan::create([
      'pelapor_id' => $pelapor->id,
      'dibuat_oleh_tipe' => $akunKelurahan ? self::TIPE_KELURAHAN : self::TIPE_ADMIN,
      'dibuat_oleh_user_id' => $akunKelurahan ? null : Auth::guard('web')->id(),
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
        $path = "hantu-banyu/{$laporan->kode}/foto_laporan/{$namaFoto}";
        $file->storeAs("public/hantu-banyu/{$laporan->kode}/foto_laporan", $namaFoto);
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
      ['kode' => $laporan->kode]
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

    // Akun kelurahan hanya melihat laporan di kelurahannya; admin melihat
    // seluruh kelurahan (kelurahanId null = tidak dibatasi).
    $kelurahanId = $this->kelurahanId();

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
        $q->where('hantu_banyu_laporan.kode', 'LIKE', "%$searchQuery%")
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

    // Asal pembuat laporan: operator kelurahan atau admin UPTD.
    $pelaporFilter = $request->input('pelapor_filter', '');
    if (in_array($pelaporFilter, [self::TIPE_KELURAHAN, self::TIPE_ADMIN], true)) {
      $query->where('hantu_banyu_laporan.dibuat_oleh_tipe', $pelaporFilter);
    } else {
      $pelaporFilter = '';
    }

    // Rentang tanggal laporan masuk. Batas akhir memakai satu hari penuh
    // supaya laporan yang masuk sore hari di tanggal itu tetap ikut terjaring.
    $tanggalDari = $this->tanggalValid($request->input('tanggal_dari'));
    $tanggalSampai = $this->tanggalValid($request->input('tanggal_sampai'));

    // Rentang terbalik (dari > sampai) ditukar, bukan ditolak - pemakainya
    // jelas bermaksud rentang yang sama.
    if ($tanggalDari && $tanggalSampai && $tanggalDari->gt($tanggalSampai)) {
      [$tanggalDari, $tanggalSampai] = [$tanggalSampai, $tanggalDari];
    }

    if ($tanggalDari) {
      $query->where('hantu_banyu_laporan.created_at', '>=', $tanggalDari->copy()->startOfDay());
    }

    if ($tanggalSampai) {
      $query->where('hantu_banyu_laporan.created_at', '<=', $tanggalSampai->copy()->endOfDay());
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
      'pelapor_filter' => $pelaporFilter,
      'tanggal_dari' => $tanggalDari?->toDateString() ?? '',
      'tanggal_sampai' => $tanggalSampai?->toDateString() ?? '',
      'sort_option' => $sortOption,
    ]);
  }

  /**
   * Terima tanggal dari form (format Y-m-d milik <input type="date">).
   * Isian ngawur diperlakukan sebagai "tidak difilter", bukan error -
   * filter tanggal bukan bagian yang layak menggagalkan seluruh halaman.
   */
  private function tanggalValid(?string $nilai): ?Carbon
  {
    if (!$nilai) {
      return null;
    }

    try {
      return Carbon::createFromFormat('Y-m-d', $nilai);
    } catch (\Throwable) {
      return null;
    }
  }

  public function show($kode)
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
    ])->where('kode', $kode)->firstOrFail();

    // Akun kelurahan hanya boleh membuka laporan di kelurahannya; admin bebas.
    $kelurahanId = $this->kelurahanId();
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

  public function pdf(Request $request, $kode)
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
    ])->where('kode', $kode)->firstOrFail();

    // Get formatted date and time
    $tanggal_laporan = Carbon::parse($laporan->created_at)->format('d F Y');
    $waktu_laporan = Carbon::parse($laporan->created_at)->format('H:i');

    // Generate the report URL for QR code
    $show_url = route('guest.hantu-banyu.pengaduan.show', ['kode' => $laporan->kode]);

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
    $filename = '[Hantu Banyu] Bukti Pengaduan Nomor ' . $laporan->kode . '.pdf';

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

  public function result($kode, Request $request)
  {
    $laporan = HantuBanyuLaporan::with([
      'pelapor',
      'kecamatan',
      'kelurahan'
    ])->where('kode', $kode)->firstOrFail();

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