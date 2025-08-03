<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Support\Facades\Http;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\JalanPeduliPelapor;
use App\Models\JalanPeduliLaporan;
use App\Models\JalanPeduliStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Guest\JalanPeduliPelaporController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

use App\Services\IpInfoService;
use App\Models\JalanPeduliIPLog;

class JalanPeduliLaporanGuestController extends Controller
{
    public function create()
    {
        // Ambil data kecamatan dan kelurahan untuk dropdown
        $kecamatans = \App\Models\Kecamatan::orderBy('nama')->get();
        $kelurahans = \App\Models\Kelurahan::orderBy('nama')->get();

        return view('guest.pages.jalan-peduli.laporan.create-laporan', [
            'meta_description' => 'Buat Laporan Jalan Peduli - Layanan pelaporan kerusakan jalan di Kota Samarinda.',
            'page_title' => 'Buat Laporan Jalan Peduli',
            'kecamatans' => $kecamatans,
            'kelurahans' => $kelurahans
        ]);
    }

    protected function sanitizeAndValidateTextInput($input, $fieldName, $maxLength, $required = true)
    {
        // Jika field wajib dan input kosong
        if ($required && empty(trim($input))) {
            $validator = Validator::make([], [], []);
            $validator->errors()->add($fieldName, "Field {$fieldName} wajib diisi.");
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Jika input kosong dan tidak wajib, kembalikan null
        if (!$required && empty(trim($input))) {
            return null;
        }

        // Bersihkan input dari tag HTML dan encode karakter khusus
        $cleanedInput = strip_tags($input);
        $cleanedInput = htmlspecialchars($cleanedInput, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Periksa panjang input
        if (strlen($cleanedInput) > $maxLength) {
            $validator = Validator::make([], [], []);
            $validator->errors()->add($fieldName, "Field {$fieldName} tidak boleh lebih dari {$maxLength} karakter.");
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Daftar karakter yang diizinkan (huruf, angka, spasi, tanda baca umum)
        $allowedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 .,?!-:/';
        $cleanedInputCheck = str_split($cleanedInput);
        foreach ($cleanedInputCheck as $char) {
            if (strpos($allowedChars, $char) === false) {
                $validator = Validator::make([], [], []);
                $validator->errors()->add($fieldName, "Field {$fieldName} berisi karakter tidak valid.");
                throw new \Illuminate\Validation\ValidationException($validator);
            }
        }
        return $cleanedInput;
    }

    public function store(Request $request)
    {
        // 1. Verifikasi Captcha di Backend
        $captchaResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret'   => env('TURNSTILE_SECRET'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$captchaResponse->json('success')) {
            return back()->withErrors(['captcha' => 'Verifikasi keamanan gagal. Silakan coba lagi.'])->withInput();
        }

        // 2. Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            'nama_lengkap'             => 'required|string|max:255',
            'nomor_ponsel'             => 'required|regex:/^08[0-9]{8,11}$/',
            'email'                    => 'nullable|email|max:255',
            'latitude'                 => 'required|numeric',
            'longitude'                => 'required|numeric',
            'foto_kerusakan'           => 'required|array|min:1',
            'foto_kerusakan.*'         => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'kecamatan_id'             => 'required|exists:kecamatan,id',
            'kelurahan_id'             => 'required|exists:kelurahan,id',
            'lokasi_kecamatan_id'      => 'required|exists:kecamatan,id',
            'lokasi_kelurahan_id'      => 'required|exists:kelurahan,id',
            'rt_pelapor'               => 'nullable|digits_between:1,3',
            'rw_pelapor'               => 'nullable|digits_between:1,3',
            'dokumen_pendukung'        => 'nullable|mimes:pdf|max:10240',
            'rating_kepuasan'          => 'required|integer|min:1|max:5',
            'jenis_kerusakan'          => 'nullable|string',
            'tingkat_kerusakan'        => 'nullable|string',
        ], [
            'foto_kerusakan.required' => 'Anda wajib mengunggah setidaknya satu foto kerusakan.',
            'foto_kerusakan.min'      => 'Anda wajib mengunggah setidaknya satu foto kerusakan.',
            'foto_kerusakan.*.image'  => 'File yang diunggah harus berupa gambar.',
            'foto_kerusakan.*.mimes'  => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'foto_kerusakan.*.max'    => 'Ukuran setiap foto tidak boleh lebih dari 10MB.',
            'nomor_ponsel.regex'      => 'Format nomor ponsel tidak valid. Contoh: 081234567890.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // validasi
            $alamat_pelapor = $this->sanitizeAndValidateTextInput($request->alamat_pelapor, 'alamat_pelapor', 1000);
            $alamat_lengkap_kerusakan = $this->sanitizeAndValidateTextInput($request->alamat_lengkap_kerusakan, 'alamat_lengkap_kerusakan', 1000);
            $deskripsi_laporan = $this->sanitizeAndValidateTextInput($request->deskripsi_laporan, 'deskripsi_laporan', 1000);
            $feedback = $this->sanitizeAndValidateTextInput($request->feedback, 'feedback', 1000, false);

            // =========================================================================
            // [MODIFIKASI] Blok Pengecekan Duplikat Koordinat Persis
            // =========================================================================
            $newLat = (float) $request->latitude;
            $newLon = (float) $request->longitude;

            // Status yang dianggap "aktif"
            $activeStatusNames = ['pending', 'disposisi', 'telah_disurvei', 'sedang_dikerjakan', 'belum_dikerjakan'];
            $activeStatusIds = JalanPeduliStatus::whereIn('nama_status', $activeStatusNames)->pluck('status_id');

            // Konversi ke string dengan presisi tinggi untuk perbandingan persis
            $newLatStr = number_format($newLat, 10, '.', '');
            $newLonStr = number_format($newLon, 10, '.', '');

            // Cek apakah sudah ada laporan aktif dengan koordinat persis sama
            $duplicateLaporan = JalanPeduliLaporan::with('status')
                ->whereIn('status_id', $activeStatusIds)
                ->whereRaw('CAST(latitude AS DECIMAL(12,10)) = ?', [$newLatStr])
                ->whereRaw('CAST(longitude AS DECIMAL(12,10)) = ?', [$newLonStr])
                ->first();

            if ($duplicateLaporan) {
                $statusName = optional($duplicateLaporan->status)->nama_status ?? 'sedang diproses';
                $statusMap = [
                    'pending'            => 'Pending',
                    'disposisi'          => 'Disposisi',
                    'telah_disurvei'     => 'Telah Disurvei',
                    'sedang_dikerjakan'  => 'Sedang Dikerjakan',
                    'belum_dikerjakan'   => 'Belum Dikerjakan',
                    'telah_dikerjakan'   => 'Telah Dikerjakan',
                ];
                $statusName = $statusMap[$statusName] ?? ucwords(str_replace('_', ' ', $statusName));
                $message = "Gagal mengirim laporan. Sudah ada laporan aktif lain (ID: <b>{$duplicateLaporan->id_laporan}</b>) yang dilaporkan pada lokasi dengan koordinat persis sama (status: '<b>{$statusName}</b>'). Mohon pilih lokasi yang berbeda.";

                return back()->withErrors(['lokasi' => $message])->withInput();
            }
            // =========================================================================
            // Akhir dari Blok Pengecekan Lokasi
            // =========================================================================

            // 3. Simpan data Pelapor
            $pelapor = JalanPeduliPelaporController::simpanAtauAmbilPelapor(
            [
                    'nama_lengkap' => $request->nama_lengkap,
                    'nomor_ponsel' => $request->nomor_ponsel,
                    'email' => $request->email,
                    'alamat_pelapor' => $alamat_pelapor,
                    'kecamatan_id' => $request->kecamatan_id,
                    'kelurahan_id' => $request->kelurahan_id,
                    'rt' => $request->rt_pelapor,
                    'rw' => $request->rw_pelapor,
                ]
            );

            // simpan ip
            // $ipInfo = IpInfoService::getIpInfo();


            // 4. Proses dan Simpan Foto
            $foto_filenames = [];
            if ($request->hasFile('foto_kerusakan')) {
                foreach ($request->file('foto_kerusakan') as $file) {
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('foto_kerusakan', $filename, 'public');
                    $foto_filenames[] = $filename;
                }
            }

            // proses pdf
            $dokumenFilename = null;
            if ($request->hasFile('dokumen_pendukung')) {
                $pdfFile = $request->file('dokumen_pendukung');
                $dokumenFilename = Str::uuid() . '.' . $pdfFile->getClientOriginalExtension();
                $pdfFile->storeAs('dokumen_pendukung', $dokumenFilename, 'public');
            }

            // 5. Buat ID Laporan unik
            $id_tahun = Carbon::now()->format('y');
            $id_kecamatan = substr(str_pad($request->lokasi_kecamatan_id, 2, '0', STR_PAD_LEFT), -2);
            $id_kelurahan = substr(str_pad($request->lokasi_kelurahan_id, 2, '0', STR_PAD_LEFT), -2);
            $prefix = $id_tahun . $id_kecamatan . $id_kelurahan;
            $lastLaporan = JalanPeduliLaporan::where('id_laporan', 'like', $prefix . '%')->orderBy('id_laporan', 'desc')->first();
            $nextNumber = $lastLaporan ? ((int) substr($lastLaporan->id_laporan, -4)) + 1 : 1;
            $id_laporan = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // 6. Buat entri Laporan baru
            JalanPeduliLaporan::create([
                'id_laporan'               => $id_laporan,
                'nomor_ponsel'             => $pelapor->nomor_ponsel,
                'alamat_lengkap_kerusakan' => $alamat_lengkap_kerusakan,
                'deskripsi_laporan'        => $deskripsi_laporan,
                'link_koordinat'           => "https://www.google.com/maps?q={$request->latitude},{$request->longitude}",
                'latitude'                 => $request->latitude,
                'longitude'                => $request->longitude,
                'foto_kerusakan'           => json_encode($foto_filenames),
                'jenis_kerusakan'          => $request->jenis_kerusakan,
                'tingkat_kerusakan'        => $request->tingkat_kerusakan,
                'dokumen_pendukung'        => $dokumenFilename,
                'kecamatan_id'             => $request->lokasi_kecamatan_id,
                'kelurahan_id'             => $request->lokasi_kelurahan_id,
                'feedback'                 => $feedback,
                'rating_kepuasan'          => $request->rating_kepuasan,
                'status_id'                => 1, // Status default "pending" atau "masuk"
            ]);

            $ipInfo = IpInfoService::getIpInfo();
            if ($ipInfo && isset($ipInfo['ipAddress'])) {
                JalanPeduliIPLog::create([
                    'pelapor_id' => $pelapor->id,
                    'laporan_id' => $id_laporan, // Tambahkan ini
                    'ip_address' => $ipInfo['ipAddress'],
                    'latitude'   => $ipInfo['latitude'] ?? null,
                    'longitude'  => $ipInfo['longitude'] ?? null,
                    'kota'       => $ipInfo['cityName'] ?? null,
                    'provinsi'   => $ipInfo['regionName'] ?? null,
                ]);
            }

            // 7. Siapkan data untuk notifikasi sukses
            $successData = [
                'message' => "Laporan Anda dengan ID: {$id_laporan} telah berhasil dikirim. Terima kasih!",
                'id_laporan' => $id_laporan,
                'download_url'  => route('laporan.download', ['id_laporan' => $id_laporan])
            ];

            // 8. Hapus input lama dari session SETELAH berhasil
            $request->session()->forget('errors');
            $request->session()->flash('_old_input', []);

            // 9. Redirect kembali dengan notifikasi sukses di session
            return redirect()->route('guest.jalan-peduli.laporan.store')->with('success_data', $successData);

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            // Jika ada error server, redirect kembali dengan pesan error umum
            return back()->with('error_server', 'Terjadi kesalahan di server saat mencoba menyimpan laporan.')->withInput();
        }
    }

    public function downloadInvoice($id_laporan)
    {
        $laporan = JalanPeduliLaporan::with(['kecamatan', 'kelurahan', 'pelapor', 'status'])
            ->where('id_laporan', $id_laporan)
            ->firstOrFail();

        $data = ['laporan' => $laporan];
        $pdf = Pdf::loadView('guest.pages.jalan-peduli.laporan.invoice-pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('bukti-laporan-' . $laporan->id_laporan . '.pdf');
    }

    public function index(Request $request)
    {
        $query = JalanPeduliLaporan::with(['kecamatan', 'kelurahan', 'pelapor', 'status'])
                ->orderBy('created_at', 'desc');

        // [MODIFIKASI] Logika pencarian diperbarui untuk 3 kriteria
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id_laporan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('alamat_lengkap_kerusakan', 'like', '%' . $searchTerm . '%'); // Mencari di alamat kerusakan
            });
        }

        if ($request->filled('tingkat_kerusakan_filter')) {
            $query->where('tingkat_kerusakan', $request->tingkat_kerusakan_filter);
        }
        
        // Sisa logika filter status tidak berubah
        if ($request->filled('status_filter')) {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('nama_status', $request->status_filter);
            });
        } else {
            // Logika default untuk tidak menampilkan 'reject' dan 'pending' (jika tidak sedang mencari)
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('nama_status', '!=', 'reject');
                // Hanya sembunyikan pending jika tidak ada keyword pencarian spesifik
                if (!$request->filled('search')) {
                    $q->where('nama_status', '!=', 'pending');
                }
            });
        }

        $laporans = $query->paginate(5)->appends($request->query());

        return view('guest.pages.jalan-peduli.laporan.data',[
            'meta_description' => 'Buat Laporan Jalan Peduli - Layanan pelaporan kerusakan jalan di Kota Samarinda.',
            'page_title' => 'Buat Laporan Jalan Peduli'
        ], compact('laporans'));
    }
    
    public function getPublicMapStats(Request $request)
    {
        try {
            // Mengambil ID status yang relevan untuk peta publik
            $desiredStatusNames = ['disposisi', 'telah_disurvei', 'sedang_dikerjakan', 'telah_dikerjakan', 'belum_dikerjakan'];
            $statusIds = JalanPeduliStatus::whereIn('nama_status', $desiredStatusNames)->pluck('status_id')->toArray();

            if (empty($statusIds)) {
                Log::warning('Tidak ada status ID yang cocok untuk peta publik ditemukan untuk nama: ' . implode(', ', $desiredStatusNames));
                return response()->json([
                    'belum_dikerjakan' => 0,
                    'sedang_dikerjakan' => 0,
                    'telah_dikerjakan' => 0,
                    'telah_disurvei' => 0,
                    'disposisi' => 0,
                ]);
            }

            $stats = JalanPeduliLaporan::query()
                ->select('status_id', \DB::raw('count(*) as total'))
                ->whereIn('status_id', $statusIds)
                ->groupBy('status_id')
                ->get();

            // Membuat array hasil dengan default 0 jika status tidak ada
            $results = [
                'belum_dikerjakan' => 0,
                'sedang_dikerjakan' => 0,
                'telah_dikerjakan' => 0,
                'telah_disurvei' => 0,
                'disposisi' => 0,
            ];

            // Memetakan kembali ke nama status agar mudah digunakan di frontend
            $statusMapping = JalanPeduliStatus::whereIn('status_id', $statusIds)->pluck('nama_status', 'status_id')->toArray();

            foreach ($stats as $stat) {
                $namaStatus = $statusMapping[$stat->status_id] ?? null;
                if ($namaStatus) {
                    $results[$namaStatus] = $stat->total;
                }
            }

            Log::info('Stats laporan publik diambil: ' . json_encode($results));
            return response()->json($results);

        } catch (\Exception $e) {
            Log::error("Error fetching public map statistics: " . $e->getMessage());
            // Mengembalikan nilai default jika terjadi error
            return response()->json([
                'belum_dikerjakan' => '-',
                'sedang_dikerjakan' => '-',
                'telah_dikerjakan' => '-',
                'telah_disurvei' => '-',
                'disposisi' => '-',
            ], 500);
        }
    }
    
    public function getPublicMapCoordinates(Request $request)
    {
        try {
            $desiredStatusNames = ['disposisi', 'telah_disurvei', 'sedang_dikerjakan', 'telah_dikerjakan', 'belum_dikerjakan'];
            $statusIds = JalanPeduliStatus::whereIn('nama_status', $desiredStatusNames)->pluck('status_id')->toArray();

            if (empty($statusIds)) {
                Log::warning('Tidak ada status ID yang cocok untuk peta publik ditemukan untuk nama: ' . implode(', ', $desiredStatusNames));
                return response()->json([]);
            }

            $query = JalanPeduliLaporan::with(['status' => function ($query) {
                $query->select('status_id', 'nama_status');
            }])
                ->whereIn('status_id', $statusIds)
                ->whereNotNull('latitude')->whereNotNull('longitude')
                ->where('latitude', '!=', '')->where('longitude', '!=', '')
                ->select('id_laporan', 'latitude', 'longitude', 'deskripsi_laporan', 'status_id', 'foto_kerusakan', 'tingkat_kerusakan', 'created_at', 'nomor_ponsel', 'alamat_lengkap_kerusakan');

            // [BARU] Tambahkan logika pencarian
            if ($request->filled('search')) {
                $searchTerm = $request->input('search');
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id_laporan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nomor_ponsel', 'like', '%' . $searchTerm . '%')
                    ->orWhere('alamat_lengkap_kerusakan', 'like', '%' . $searchTerm . '%');
                });
            }

            // [BARU] Tambahkan filter status
            if ($request->filled('status')) {
                $query->whereHas('status', function ($q) use ($request) {
                    $q->where('nama_status', $request->input('status'));
                });
            }

            // [BARU] Tambahkan filter tingkat kerusakan
            if ($request->filled('tingkat')) {
                $query->where('tingkat_kerusakan', $request->input('tingkat'));
            }

            $laporans = $query->orderBy('created_at', 'desc')->limit(500)->get();

            $transformedLaporans = $laporans->map(function ($laporan) {
                $fotoKerusakanArray = is_string($laporan->foto_kerusakan) ? json_decode($laporan->foto_kerusakan, true) : $laporan->foto_kerusakan;
                if (!is_array($fotoKerusakanArray)) {
                    $fotoKerusakanArray = [];
                }

                $latitude = $laporan->latitude;
                $longitude = $laporan->longitude;
                if (!is_numeric($latitude) || !is_numeric($longitude)) {
                    Log::warning("Koordinat tidak valid untuk laporan ID: {$laporan->id_laporan}. Lat: {$latitude}, Lon: {$longitude}");
                }

                return [
                    'id_laporan'        => $laporan->id_laporan,
                    'latitude'          => (float) $latitude,
                    'longitude'         => (float) $longitude,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'foto_kerusakan'    => $fotoKerusakanArray,
                    'status'            => $laporan->status ? ['nama_status' => $laporan->status->nama_status] : ['nama_status' => 'Tidak Diketahui'],
                    'tingkat_kerusakan' => $laporan->tingkat_kerusakan,
                    'created_at'        => $laporan->created_at->toIso8601String(),
                ];
            });

            Log::info('Mengambil ' . $transformedLaporans->count() . ' laporan untuk peta publik.');
            return response()->json($transformedLaporans);

        } catch (\Exception $e) {
            Log::error("Error fetching public map coordinates: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['error' => 'Gagal mengambil data peta publik.'], 500);
        }
    }

    public function getCoordinatesApi()
    {
        $laporans = JalanPeduliLaporan::with('status:status_id,nama_status')
            ->select('id_laporan', 'deskripsi_laporan', 'latitude', 'longitude', 'status_id', 'created_at', 'foto_kerusakan', 'tingkat_kerusakan')
            ->get()
            ->map(function ($laporan) {
                $fotoKerusakanArray = is_string($laporan->foto_kerusakan) ? json_decode($laporan->foto_kerusakan, true) : $laporan->foto_kerusakan;
                if (!is_array($fotoKerusakanArray)) { $fotoKerusakanArray = []; }
                return [
                    'id_laporan' => $laporan->id_laporan,
                    'deskripsi_laporan' => $laporan->deskripsi_laporan,
                    'latitude' => (float)$laporan->latitude,
                    'longitude' => (float)$laporan->longitude,
                    'created_at' => $laporan->created_at->toIso8601String(),
                    'foto_kerusakan' => $fotoKerusakanArray,
                    'status' => $laporan->status ? ['nama_status' => $laporan->status->nama_status] : ['nama_status' => 'Tidak Diketahui'],
                    'tingkat_kerusakan' => $laporan->tingkat_kerusakan
                ];
            });
        return response()->json($laporans);
    }
    
    //     public function adminDashboard(Request $request)
    // {
    //     // Memulai query builder dengan eager loading relasi yang dibutuhkan
    //     $query = Laporan::with(['kecamatan', 'kelurahan', 'status', 'pelapor'])
    //         ->orderBy('created_at', 'desc'); // Urutkan dari yang terbaru

    //     // --- Logika Filter ---

    //     // 1. Filter default: Abaikan 'reject' dan 'pending' dari tampilan utama
    //     // Kita menggunakan whereHas agar bisa memeriksa relasi status
    //     $query->whereHas('status', function ($q) {
    //         $q->whereNotIn('nama_status', ['reject', 'pending']);
    //     });

    //     // 2. Filter Pencarian (ID Laporan atau Nomor Ponsel)
    //     // Menggunakan 'like' untuk fleksibilitas, cocokkan sebagian teks
    //     if ($request->filled('search')) {
    //         $searchTerm = $request->input('search');
    //         $query->where(function ($q) use ($searchTerm) {
    //             $q->where('id_laporan', 'like', '%' . $searchTerm . '%')
    //               ->orWhere('nomor_ponsel', 'like', '%' . $searchTerm . '%');
    //         });
    //     }

    //     // 3. Filter Tingkat Kerusakan
    //     // Memastikan nilai yang dikirim sama persis dengan yang ada di database (case-insensitive)
    //     if ($request->filled('tingkat_kerusakan_filter')) {
    //         $tingkat = $request->input('tingkat_kerusakan_filter');
    //         // Menggunakan whereRaw untuk perbandingan case-insensitive dan menghilangkan spasi
    //         // Ini adalah solusi jika database Anda memiliki inkonsistensi 'case' atau spasi
    //         // Jika data Anda sudah benar-benar bersih (semua lowercase, tanpa spasi), Anda bisa gunakan:
    //         // $query->where('tingkat_kerusakan', $tingkat);
    //         $query->whereRaw('LOWER(REPLACE(tingkat_kerusakan, " ", "")) = LOWER(REPLACE(?, "", ""))', [$tingkat]);
    //     }

    //     // 4. Filter Jenis Kerusakan
    //     // Memastikan nilai yang dikirim sama persis dengan yang ada di database
    //     if ($request->filled('jenis_kerusakan_filter')) {
    //         $query->where('jenis_kerusakan', $request->input('jenis_kerusakan_filter'));
    //     }

    //     // 5. Filter Status Kerusakan
    //     // Memastikan nama_status di database benar-benar cocok dengan yang dikirim
    //     if ($request->filled('status_kerusakan_filter')) {
    //         $query->whereHas('status', function ($q) use ($request) {
    //             $q->where('nama_status', $request->input('status_kerusakan_filter'));
    //         });
    //     }
    //     // --- Akhir Logika Filter ---

    //     // Pagination
    //     $perPage = 6; // Jumlah item per halaman
    //     $laporans = $query->paginate($perPage)->appends($request->query()); // appends() agar parameter filter tetap ada saat navigasi halaman

    //     // Handle redirect jika nomor halaman yang diminta melebihi halaman terakhir yang ada
    //     if ($laporans->currentPage() > $laporans->lastPage() && $laporans->total() > 0) {
    //         // Buat ulang URL dengan halaman terakhir yang valid
    //         return redirect()->route('admin.dashboard', array_merge($request->except('page'), ['page' => $laporans->lastPage()]));
    //     }

    //     // Tampilkan view dashboard dengan data laporan yang sudah difilter
    //     return view('admin.dashboard', compact('laporans'));
    // }

    // public function edit($id)
    // {
    //     $laporan = Laporan::with(['kecamatan', 'kelurahan'])->where('id_laporan', $id)->firstOrFail();
    //     return view('admin.pages.jalan-peduli.tindaklanjuti-laporan.edit', compact('laporan'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $laporan = Laporan::findOrFail($id);

    //     // Validasi jika perlu
    //     $request->validate([
    //         'status_id'        => 'required|exists:status,status_id',
    //         'keterangan'       => 'nullable|string',
    //         'jenis_kerusakan'  => 'nullable|string|max:255',
    //         'tingkat_kerusakan'=> 'nullable|string|max:255',
    //         'foto_lanjutan'    => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
    //     ]);

    //     if ($request->hasFile('foto_lanjutan')) {
    //         $file = $request->file('foto_lanjutan');
    //         $filename = \Str::uuid() . '.' . $file->getClientOriginalExtension();
    //         $file->storeAs('foto_lanjutan', $filename, 'public');
    //         $laporan->foto_lanjutan = $filename;
    //     }

    //     // Update kolom lainnya
    //     $laporan->status_id = $request->status_id;
    //     $laporan->keterangan = $request->keterangan;
    //     $laporan->jenis_kerusakan = $request->jenis_kerusakan;
    //     $laporan->tingkat_kerusakan = $request->tingkat_kerusakan;

    //     $laporan->save();

    //     return redirect()->route('admin.jalan-peduli.laporan-masuk.index')->with('success', 'Laporan berhasil diperbarui');
    // }

    // public function getKelurahans($kecamatan_id)
    // {
    //     try {
    //         $kelurahans = \App\Models\Kelurahan::where('kecamatan_id', $kecamatan_id)
    //             ->orderBy('nama')
    //             ->get(['id', 'nama'])
    //             ->toArray(); // pastikan array

    //         return response()->json([
    //             'success' => true,
    //             'data' => $kelurahans // selalu array
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'data' => [], // tetap array meski error
    //             'message' => 'Gagal mengambil data kelurahan'
    //         ], 500);
    //     }
    // }

    // public function destroy($id)
    // {
    //     $laporan = Laporan::findOrFail($id);
    //     $photos = json_decode($laporan->foto_kerusakan, true) ?? [];
    //     foreach ($photos as $photo) {
    //         Storage::disk('public')->delete('foto_kerusakan/' . $photo);
    //     }
    //     $laporan->delete();
    //     return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    // }
}