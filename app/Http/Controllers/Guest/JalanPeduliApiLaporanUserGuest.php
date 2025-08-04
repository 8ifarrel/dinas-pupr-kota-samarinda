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

class JalanPeduliApiLaporanUserGuest extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelapor' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|regex:/^[0-9\-\+\s]+$/|max:20',
            'email_pelapor' => 'required|email|max:255',
            'alamat_pelapor' => 'required|string|max:500',
            'jenis_kerusakan' => 'required|string|max:255',
            'deskripsi_kerusakan' => 'required|string',
            'alamat_lengkap_kerusakan' => 'required|string',
            'kecamatan_id' => 'required|integer|exists:kecamatan,id',
            'kelurahan_id' => 'required|integer|exists:kelurahan,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto_kerusakan' => 'required|array',
            'rating_kepuasan' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'dokumen_pendukung' => 'nullable|mimes:pdf|max:10240', 
            'foto_kerusakan.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
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
            $pelapor = JalanPeduliPelapor::firstOrCreate(
                ['email' => $request->input('email_pelapor')],
                [
                    'nama_lengkap' => $request->input('nama_pelapor'),
                    'nomor_ponsel' => $request->input('nomor_telepon'),
                    'alamat' => $request->input('alamat_pelapor'),
                ]
            );

            // Generate ID laporan terlebih dahulu
            $id_laporan = $this->generateIdLaporan(
                $request->input('kecamatan_id'),
                $request->input('kelurahan_id')
            );

            // Proses dan Simpan Foto dengan ID Laporan
            $fotoPaths = [];
            if ($request->hasFile('foto_kerusakan')) {
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
                'jenis_kerusakan' => $request->input('jenis_kerusakan'),
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
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal pada server. Silakan coba lagi nanti.'
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
}