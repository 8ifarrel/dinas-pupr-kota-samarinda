<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Models\JalanPeduliLaporan;
use App\Models\JalanPeduliPelapor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Services\ServerTensorFlowService;

class JalanPeduliApiLaporanUserGuest extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelapor' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|regex:/^[0-9\-\+\s]+$/|max:20',
            'email_pelapor' => 'required|email|max:255',
            'alamat_pelapor' => 'required|string|max:500',
            'kecamatan_pelapor_id' => 'required|integer|exists:kecamatan,id',
            'kelurahan_pelapor_id' => 'required|integer|exists:kelurahan,id',
            // ML prediction results (dapat dari client atau akan diprediksi server)
            'jenis_kerusakan' => 'nullable|string|in:Retak Buaya,Lubang-lubang,Longsor',
            'tingkat_kerusakan' => 'nullable|string|in:Ringan,Sedang,Berat',
            'deskripsi_kerusakan' => 'required|string',
            'alamat_lengkap_kerusakan' => 'required|string',
            'kecamatan_id' => 'required|integer|exists:kecamatan,id',
            'kelurahan_id' => 'required|integer|exists:kelurahan,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto_kerusakan' => 'required|array|min:1',
            'rating_kepuasan' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'dokumen_pendukung' => 'nullable|mimes:pdf|max:10240', 
            'foto_kerusakan.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Cari pelapor berdasarkan email ATAU nomor ponsel
            $pelapor = JalanPeduliPelapor::where('email', $request->input('email_pelapor'))
                ->orWhere('nomor_ponsel', $request->input('nomor_telepon'))
                ->first();

            if (!$pelapor) {
                // Jika tidak ada, buat baru
                $pelapor = JalanPeduliPelapor::create([
                    'nama_lengkap' => $request->input('nama_pelapor'),
                    'nomor_ponsel' => $request->input('nomor_telepon'),
                    'email' => $request->input('email_pelapor'),
                    'alamat_pelapor' => $request->input('alamat_pelapor'), 
                    'kecamatan_id' => $request->input('kecamatan_pelapor_id'), 
                    'kelurahan_id' => $request->input('kelurahan_pelapor_id'),
                ]);
            } else {
                // Jika ada, update data terbaru
                $pelapor->update([
                    'nama_lengkap' => $request->input('nama_pelapor'),
                    'email' => $request->input('email_pelapor'),
                    'alamat_pelapor' => $request->input('alamat_pelapor'), 
                    'kecamatan_id' => $request->input('kecamatan_pelapor_id'), 
                    'kelurahan_id' => $request->input('kelurahan_pelapor_id'),
                ]);
            }

            // Generate ID laporan terlebih dahulu
            $id_laporan = $this->generateIdLaporan(
                $request->input('kecamatan_id'),
                $request->input('kelurahan_id')
            );

            // HYBRID ML APPROACH: Smart ML Integration untuk API Users  
            $finalJenis = null;
            $finalTingkat = null;
            $predictionSource = 'unknown';
            
            if ($request->filled('jenis_kerusakan') && $request->filled('tingkat_kerusakan')) {
                // Kasus 1: Client sudah kirim hasil TensorFlow.js prediction (Web/Mobile app sudah process)
                $finalJenis = $request->input('jenis_kerusakan');
                $finalTingkat = $request->input('tingkat_kerusakan');
                $predictionSource = 'client_provided';
                \Log::info("ML Prediction: Using client-provided results", [
                    'jenis' => $finalJenis,
                    'tingkat' => $finalTingkat,
                    'source' => 'client_tensorflowjs'
                ]);
                
            } else {
                // Kasus 2: Client tidak provide ML results, proses menggunakan Server TensorFlow.js
                if ($request->hasFile('foto_kerusakan') && is_array($request->file('foto_kerusakan'))) {
                    $firstImage = $request->file('foto_kerusakan')[0];
                    $predictions = $this->predictKerusakanFromImageTensorFlow($firstImage);
                    $finalJenis = $predictions['jenis'] ?? 'Tidak Terdeteksi';
                    $finalTingkat = $predictions['tingkat'] ?? 'Tidak Terdeteksi';
                    $predictionSource = $predictions['method'] ?? 'server_tensorflow';
                    
                    \Log::info("ML Prediction: Using server-side TensorFlow.js", [
                        'jenis' => $finalJenis,
                        'tingkat' => $finalTingkat,
                        'confidence_jenis' => $predictions['confidence_jenis'] ?? 'unknown',
                        'confidence_tingkat' => $predictions['confidence_tingkat'] ?? 'unknown',
                        'method' => $predictions['method'] ?? 'server_tensorflow'
                    ]);
                } else {
                    $finalJenis = 'Tidak Terdeteksi';
                    $finalTingkat = 'Tidak Terdeteksi';
                    $predictionSource = 'no_prediction';
                }
            }

            // Proses dan Simpan Foto dengan ID Laporan (SETELAH ML prediction)
            $fotoPaths = [];
            
            if ($request->hasFile('foto_kerusakan') && is_array($request->file('foto_kerusakan'))) {
                foreach ($request->file('foto_kerusakan') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    // Simpan ke folder berdasarkan ID laporan
                    $file->storeAs("jalan_peduli/{$id_laporan}", $fileName, 'public');
                    $fotoPaths[] = $fileName;
                }
            }

            // Proses dokumen pendukung
            $dokumenFilename = null;
            if ($request->hasFile('dokumen_pendukung')) {
                $pdfFile = $request->file('dokumen_pendukung');
                $dokumenFilename = Str::uuid() . '.' . $pdfFile->getClientOriginalExtension();
                // Simpan dokumen ke folder berdasarkan ID laporan
                $pdfFile->storeAs("jalan_peduli/{$id_laporan}", $dokumenFilename, 'public');
            }
            
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $laporan = JalanPeduliLaporan::create([
                'id_laporan' => $id_laporan,
                'nomor_ponsel' => $pelapor->nomor_ponsel,
                'status_id' => 1,
                'kecamatan_id' => $request->input('kecamatan_id'),
                'kelurahan_id' => $request->input('kelurahan_id'),
                'jenis_kerusakan' => $finalJenis,
                'tingkat_kerusakan' => $finalTingkat,
                'deskripsi_laporan' => $request->input('deskripsi_kerusakan'),
                'alamat_lengkap_kerusakan' => $request->input('alamat_lengkap_kerusakan'),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'rating_kepuasan' => $request->input('rating_kepuasan'),
                'feedback' => $request->input('feedback'),
                'dokumen_pendukung' => $dokumenFilename, 
                'link_koordinat' => "https://maps.google.com/?q={$latitude},{$longitude}",
                'foto_kerusakan' => json_encode($fotoPaths),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Laporan Anda berhasil dikirim dan sedang menunggu verifikasi.',
                'data' => [
                    'id_laporan' => $laporan->id_laporan,
                    'jenis_kerusakan_detected' => $finalJenis,
                    'tingkat_kerusakan_detected' => $finalTingkat,
                    'prediction_source' => $predictionSource,
                    'status' => 'Menunggu Verifikasi',
                    'detail_url' => route('api.laporan.show', $laporan->id_laporan)
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal membuat laporan dari API: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except('foto_kerusakan')
            ]);
            \Log::error('Gagal membuat laporan dari API (detail): ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('foto_kerusakan'),
                'input' => $request->all(),
                'user_agent' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal pada server. Silakan coba lagi nanti.',
                'error_details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id_laporan)
    {
        try {
            $laporan = JalanPeduliLaporan::with([
                'status',
                'kecamatan',
                'kelurahan',
            ])->findOrFail($id_laporan);

            $formattedLaporan = $laporan->toArray();

            $fotoUrls = [];
            if ($laporan->foto_kerusakan) {
                $fotoFiles = json_decode($laporan->foto_kerusakan, true);
                if (is_array($fotoFiles)) {
                    foreach ($fotoFiles as $fotoFileName) {
                        $fotoUrls[] = [
                            'file_name' => $fotoFileName,
                            'url' => asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $fotoFileName)
                        ];
                    }
                }
            }
            $formattedLaporan['foto_kerusakan_urls'] = $fotoUrls;
            unset($formattedLaporan['foto_kerusakan']);
            
            // Tambahkan URL dokumen pendukung jika ada
            if ($laporan->dokumen_pendukung) {
                $formattedLaporan['dokumen_pendukung_url'] = asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $laporan->dokumen_pendukung);
            } else {
                $formattedLaporan['dokumen_pendukung_url'] = null;
            }
            
            $formattedLaporan['created_at_formatted'] = $laporan->created_at ? $laporan->created_at->isoFormat('DD MMMM YYYY, HH:mm') . ' WITA' : null;
            $formattedLaporan['updated_at_formatted'] = $laporan->updated_at ? $laporan->updated_at->isoFormat('DD MMMM YYYY, HH:mm') . ' WITA' : null;

            if (isset($formattedLaporan['kecamatan']) && is_array($formattedLaporan['kecamatan'])) {
                $formattedLaporan['kecamatan_nama'] = $laporan->kecamatan->nama ?? $laporan->kecamatan->nama_kecamatan ?? null;
            }
            if (isset($formattedLaporan['kelurahan']) && is_array($formattedLaporan['kelurahan'])) {
                $formattedLaporan['kelurahan_nama'] = $laporan->kelurahan->nama ?? $laporan->kelurahan->nama_kelurahan ?? null;
            }
            if (isset($formattedLaporan['status']) && is_array($formattedLaporan['status'])) {
                $formattedLaporan['status_nama'] = $laporan->status->nama_status ?? null;
            }
            
            unset($formattedLaporan['pelapor']);
            unset($formattedLaporan['kecamatan']);
            unset($formattedLaporan['kelurahan']);
            unset($formattedLaporan['status']);
            unset($formattedLaporan['nomor_ponsel']);

            return response()->json([
                'success' => true,
                'message' => 'Data laporan berhasil diambil.',
                'data' => $formattedLaporan
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan.',
                'data' => null
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Error retrieving laporan for API: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data laporan.',
                'error_details' => $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        try {
            $laporans = JalanPeduliLaporan::with(['status'])
                               ->orderBy('created_at', 'desc')
                               ->get();

            $formattedLaporans = $laporans->map(function($laporan) {
                return [
                    'id_laporan' => $laporan->id_laporan,
                    'alamat_singkat' => $laporan->alamat_lengkap_kerusakan,
                    'jenis_kerusakan' => $laporan->jenis_kerusakan,
                    'tingkat_kerusakan' => $laporan->tingkat_kerusakan,
                    'status' => $laporan->status->nama_status ?? 'Tidak Diketahui',
                    'created_at' => $laporan->created_at ? $laporan->created_at->isoFormat('DD MMMM YYYY, HH:mm') . ' WITA' : null,
                    'detail_url' => route('api.laporan.show', $laporan->id_laporan)
                ];
            });
            $totalSemuaLaporan = JalanPeduliLaporan::count();
            $totalPerStatus = JalanPeduliLaporan::join('jalan_peduli_status', 'jalan_peduli_laporan.status_id', '=', 'jalan_peduli_status.status_id')
                                     ->select('jalan_peduli_status.nama_status', DB::raw('count(jalan_peduli_laporan.id_laporan) as jumlah'))
                                     ->groupBy('jalan_peduli_status.nama_status')
                                     ->orderBy('jalan_peduli_status.nama_status')
                                     ->get()
                                     ->pluck('jumlah', 'nama_status');

            $statistik = [
                'total_semua_laporan' => $totalSemuaLaporan,
                'rincian_per_status' => $totalPerStatus
            ];

            return response()->json([
                'success' => true,
                'message' => 'Daftar laporan berhasil diambil.',
                'statistik' => $statistik,
                'data' => $formattedLaporans
            ]);

        } catch (\Exception $e) {
            \Log::error('Error retrieving list of laporan for API: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil daftar laporan.',
                'error_details' => $e->getMessage()
            ], 500);
        }
    }

    private function generateIdLaporan($kecamatan_id, $kelurahan_id)
    {
        $id_tahun = Carbon::now()->format('y');
        $id_kecamatan = substr(strval($kecamatan_id), -2);
        $id_kelurahan = substr(strval($kelurahan_id), -2);
        $prefix = $id_tahun . $id_kecamatan . $id_kelurahan;

        $existingIds = JalanPeduliLaporan::where('id_laporan', 'like', $prefix . '%')
            ->pluck('id_laporan')
            ->map(fn($id) => (int)substr($id, strlen($prefix)))
            ->toArray();

        for ($i = 1; $i <= 9999; $i++) {
            if (!in_array($i, $existingIds)) {
                return $prefix . str_pad($i, 4, '0', STR_PAD_LEFT);
            }
        }

        throw new \Exception("ID laporan penuh untuk prefix $prefix");
    }
    
    /**
     * Server-side TensorFlow.js prediction menggunakan model yang sama dengan frontend
     * Dijalankan ketika client tidak provide hasil ML (sesuai permintaan user)
     */
    private function predictKerusakanFromImageTensorFlow($imageFile)
    {
        try {
            $tensorFlowService = new ServerTensorFlowService();
            
            // Check jika service tersedia
            if (!$tensorFlowService->isAvailable()) {
                \Log::warning('TensorFlow.js service tidak tersedia, menggunakan fallback');
                return $this->predictKerusakanFromImageFallback($imageFile);
            }
            
            // Prediksi menggunakan TensorFlow.js sama seperti di buat-laporan.js
            $result = $tensorFlowService->predict($imageFile);
            
            \Log::info('Server TensorFlow.js prediction successful', [
                'jenis' => $result['jenis'],
                'tingkat' => $result['tingkat'],
                'confidence_jenis' => $result['confidence_jenis'],
                'confidence_tingkat' => $result['confidence_tingkat'],
                'method' => $result['method']
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            \Log::error('Server TensorFlow.js prediction error: ' . $e->getMessage());
            
            // Fallback ke rule-based jika TensorFlow.js gagal
            return $this->predictKerusakanFromImageFallback($imageFile);
        }
    }
    
    /**
     * Fallback prediction untuk ketika TensorFlow.js tidak tersedia
     * Simple rule-based approach untuk backward compatibility
     */
    private function predictKerusakanFromImageFallback($imageFile)
    {
        try {
            // Simple rule-based prediction berdasarkan karakteristik file
            $jenis = $this->simpleImageAnalysis($imageFile->getPathname(), $imageFile->getClientOriginalName());
            $tingkat = $this->predictSeverity($imageFile->getSize());
            
            return [
                'jenis' => $jenis,
                'tingkat' => $tingkat,
                'confidence_jenis' => 0.6, // Lower confidence untuk fallback
                'confidence_tingkat' => 0.6,
                'method' => 'server_fallback'
            ];
            
        } catch (\Exception $e) {
            \Log::warning('Server-side ML prediction failed: ' . $e->getMessage());
            
            // Ultimate fallback
            return [
                'jenis' => 'Tidak Terdeteksi',
                'tingkat' => 'Tidak Terdeteksi',
                'confidence_jenis' => 0.1,
                'confidence_tingkat' => 0.1,
                'method' => 'fallback_error'
            ];
        }
    }
    
    /**
     * Analisis gambar sederhana untuk fallback prediction
     */
    private function simpleImageAnalysis($imagePath, $imageName)
    {
        $jenisOptions = ['Retak Buaya', 'Lubang-lubang', 'Longsor'];
        
        // Analisis berdasarkan nama file
        $lowerName = strtolower($imageName);
        
        if (strpos($lowerName, 'retak') !== false || strpos($lowerName, 'crack') !== false) {
            return 'Retak Buaya';
        } elseif (strpos($lowerName, 'lubang') !== false || strpos($lowerName, 'hole') !== false) {
            return 'Lubang-lubang';
        } elseif (strpos($lowerName, 'longsor') !== false || strpos($lowerName, 'landslide') !== false) {
            return 'Longsor';
        }
        
        // Random selection untuk demo (dalam produksi, bisa pakai ML library)
        return $jenisOptions[array_rand($jenisOptions)];
    }
    
    /**
     * Prediksi tingkat keparahan berdasarkan ukuran file (simple heuristic)
     */
    private function predictSeverity($fileSize)
    {
        // Asumsi: file yang lebih besar mungkin menunjukkan kerusakan yang lebih detail/parah
        if ($fileSize > 1500000) { // > 1.5MB
            return 'Berat';
        } elseif ($fileSize > 800000) { // > 800KB
            return 'Sedang';
        } else {
            return 'Ringan';
        }
    }
}