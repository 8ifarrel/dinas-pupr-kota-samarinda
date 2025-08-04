<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JalanPeduliLaporan;
use App\Models\JalanPeduliStatus;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class JalanPeduliLaporanMasukAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index(Request $request)
    {
        $page_title = "Jalan Peduli - Laporan Masuk";
        $page_description = "Verifikasi, lihat, atau unduh laporan yang masuk. Laporan yang telah disetujui dapat ditindaklanjuti pada halaman Tindaklanjuti Laporan.";


        $query = JalanPeduliLaporan::with(['pelapor', 'status', 'kecamatan', 'kelurahan']);
        $statusFilter = $request->input('status_id');
        if ($statusFilter === 'accept') {
            $query->whereIn('status_id', [2,3,4,5,7]);
        } elseif ($statusFilter === '1') {
            $query->where('status_id', 1);
        }

        $laporans = $query->orderByDesc('created_at')->get();

        // Statuses untuk filter dropdown (hanya 3)
        $statuses = [
            (object)['value' => 'accept', 'label' => 'Accept'],
            (object)['value' => '1', 'label' => 'Pending'],
            (object)['value' => '', 'label' => 'Semua'],
        ];

        return view('admin.pages.jalan-peduli.laporan-masuk.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'laporans' => $laporans,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Menampilkan detail laporan masuk berdasarkan ID.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $page_title = "Jalan Peduli - Detail Laporan";
        $page_description = "Detail laporan masuk dengan ID $id";

        $laporan = JalanPeduliLaporan::with([
            'pelapor.kecamatan',
            'pelapor.kelurahan',
            'kecamatan',
            'kelurahan',
            'status',
            'ipLogs'
        ])->findOrFail($id);

        $fotoArray = $laporan->foto_kerusakan ? json_decode($laporan->foto_kerusakan, true) : [];
        $fotoArray = is_array($fotoArray) ? $fotoArray : [];

        // Embed Google Maps
        $embedUrl = '';
        if ($laporan->link_koordinat) {
            if (str_contains($laporan->link_koordinat, 'maps.google.com') || str_contains($laporan->link_koordinat, 'maps.app.goo.gl')) {
                if (preg_match('/@(-?\d+\.?\d*),(-?\d+\.?\d*)/', $laporan->link_koordinat, $matches)) {
                    $latitude = $matches[1];
                    $longitude = $matches[2];
                    $embedUrl = "https://maps.google.com/maps?q={$latitude},{$longitude}&hl=id&z=14&output=embed";
                } elseif (str_contains($laporan->link_koordinat, '?q=')) {
                    $coords = explode('?q=', $laporan->link_koordinat)[1];
                    $coords = explode('&', $coords)[0];
                    $embedUrl = "https://maps.google.com/maps?q={$coords}&hl=id&z=14&output=embed";
                }
            }
        }
        if (empty($embedUrl) && $laporan->latitude && $laporan->longitude) {
            $embedUrl = "https://maps.google.com/maps?q={$laporan->latitude},{$laporan->longitude}&hl=id&z=14&output=embed";
        }

        $ipLogs = $laporan->ipLogs ?? collect();

        return view('admin.pages.jalan-peduli.laporan-masuk.show', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'laporan' => $laporan,
            'fotoArray' => $fotoArray,
            'embedUrl' => $embedUrl,
            'ipLogs' => $ipLogs,
        ]);
    }

    /**
     * Memperbarui status laporan
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        // Setujui laporan: ubah status menjadi "belum_dikerjakan" (ambil dari tabel status)
        $laporan = JalanPeduliLaporan::findOrFail($id);

        // Hanya proses jika status saat ini pending (status_id = 1)
        if ($laporan->status_id != 1) {
            return redirect()->back()->with('error', 'Laporan hanya bisa disetujui jika masih berstatus Pending.');
        }

        $belumDikerjakan = JalanPeduliStatus::where('nama_status', 'belum_dikerjakan')->first();
        $laporan->status_id = $belumDikerjakan ? $belumDikerjakan->status_id : 2;
        $laporan->save();

        return redirect()->route('admin.jalan-peduli.laporan-masuk.index')
            ->with('success', 'Laporan berhasil disetujui. Silakan tindaklanjuti laporan ini pada halaman Tindaklanjuti Laporan.');
    }

    /**
     * Menghapus data laporan dari database berdasarkan ID.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $laporan = JalanPeduliLaporan::findOrFail($id);

        $fotoArray = $laporan->foto_kerusakan ? json_decode($laporan->foto_kerusakan, true) : [];
        if (is_array($fotoArray) && !empty($fotoArray)) {
            foreach ($fotoArray as $foto) {
                // Path: storage/app/public/jalan_peduli/{id_laporan}/{foto}
                Storage::disk('public')->delete('jalan_peduli/' . $laporan->id_laporan . '/' . $foto);
            }
            // Hapus folder jika kosong (opsional, aman diabaikan jika tidak ada)
            $folderPath = 'jalan_peduli/' . $laporan->id_laporan;
            if (empty(Storage::disk('public')->files($folderPath))) {
                Storage::disk('public')->deleteDirectory($folderPath);
            }
        }

        $laporan->delete();

        return redirect()->route('admin.jalan-peduli.laporan-masuk.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }


    // Definisikan ID status yang dianggap "Accept"
    const ACCEPT_STATUS_IDS = [2, 3, 4, 5, 7];
    const PENDING_STATUS_ID = 1;
    const REJECT_STATUS_ID = 6;
    const BELUM_DIKERJAKAN_STATUS_ID = 7;
    const DISPOSISI_STATUS_ID = 2; // Status ID untuk "Disposisi" jika diperlukan

    public function download($id_laporan)   
    {
        try {
            $laporan = JalanPeduliLaporan::with(['pelapor.kecamatan', 'pelapor.kelurahan', 'status', 'kecamatan', 'kelurahan'])->findOrFail($id_laporan);
            $timestamp = time();
            $tempDir = storage_path('app/temp/download_' . $id_laporan . '_' . $timestamp);
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $pdfPath = $tempDir . '/' . $id_laporan . '_laporan.pdf';
            try {
                $pdf = Pdf::loadView('admin.pages.jalan-peduli.laporan-masuk.laporan_single_pdf', [
                    'laporan' => $laporan,
                    'acceptStatusIds' => self::ACCEPT_STATUS_IDS,
                    'pendingStatusId' => self::PENDING_STATUS_ID,
                    'rejectStatusId' => self::REJECT_STATUS_ID,
                    'disposisiStatusId' => self::DISPOSISI_STATUS_ID, // Tambahkan ini
                ]);
                \Log::info('PDF view loaded successfully');
            } catch (\Exception $e) {
                \Log::warning('View admin.laporan_single_pdf not found, creating simple PDF: ' . $e->getMessage());
                $html = '<h1>Laporan ID: ' . $laporan->id_laporan . '</h1>';
                $html .= '<p><strong>Pelapor:</strong> ' . ($laporan->pelapor->nama_lengkap ?? '-') . '</p>';
                $html .= '<p><strong>No HP:</strong> ' . ($laporan->pelapor->nomor_ponsel ?? '-') . '</p>';
                $html .= '<p><strong>Alamat:</strong> ' . $laporan->alamat_lengkap_kerusakan . '</p>';
                $html .= '<p><strong>Deskripsi:</strong> ' . $laporan->deskripsi_laporan . '</p>';
                // Tambahkan keterangan disposisi jika ada
                if ($laporan->status_id == self::DISPOSISI_STATUS_ID && !empty($laporan->keterangan)) {
                    $html .= '<p><strong>Keterangan Disposisi:</strong> ' . $laporan->keterangan . '</p>';
                }
                $html .= '<p><strong>Tanggal:</strong> ' . $laporan->created_at->format('d M Y H:i') . '</p>';
                $pdf = Pdf::loadHTML($html);
            }
            $pdf->save($pdfPath);

            // ... (sisa method download tetap sama) ...
            if (!file_exists($pdfPath)) {
                \Log::error('PDF file was not created at: ' . $pdfPath);
                return redirect()->back()->with('error', 'Gagal membuat file PDF.');
            }
            $photoDir = $tempDir . '/folder_foto';
            if (!file_exists($photoDir)) {
                mkdir($photoDir, 0755, true);
            }
            \Log::info('Processing photos for laporan ID: ' . $id_laporan);
            $fotoArray = $laporan->foto_kerusakan ? json_decode($laporan->foto_kerusakan, true) : [];
            if (is_array($fotoArray) && !empty($fotoArray)) {
                foreach ($fotoArray as $index => $foto) {
                    $fotoPath = storage_path('app/public/jalan_peduli/'. $laporan->id_laporan . '/' . $foto); 
                    \Log::info('Checking photo path: ' . $fotoPath);
                    if (file_exists($fotoPath)) {
                        $destination = $photoDir . '/gambar_' . $id_laporan . '_' . ($index + 1) . '_' . basename($foto);
                        copy($fotoPath, $destination);
                        \Log::info('Copied photo to: ' . $destination);
                    } else {
                        \Log::error('Photo not found at: ' . $fotoPath);
                    }
                }
            } else {
                \Log::warning('No photos found or invalid JSON for laporan ID: ' . $id_laporan);
            }
            $zipPath = storage_path('app/temp/' . $id_laporan . '_' . $timestamp . '.zip');
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $zip->addFile($pdfPath, $id_laporan . '/' . $id_laporan . '_laporan.pdf');
                \Log::info('Added PDF to ZIP: ' . $id_laporan . '/' . $id_laporan . '_laporan.pdf');
                $files = glob($photoDir . '/*');
                foreach ($files as $file) {
                    $zipEntryName = $id_laporan . '/folder_foto/' . basename($file);
                    $zip->addFile($file, entryname: $zipEntryName);
                    \Log::info('Added photo to ZIP: ' . $zipEntryName);
                }
                $zip->close();
                \Log::info('ZIP created at: ' . $zipPath);
            } else {
                \Log::error('Failed to create ZIP file at: ' . $zipPath);
                return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
            }
            if (!file_exists($zipPath)) {
                \Log::error('ZIP file was not created at: ' . $zipPath);
                return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
            }
            $this->deleteDirectory($tempDir);
            return response()->download($zipPath, $id_laporan . '.zip')->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Error in download method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat download: ' . $e->getMessage());
        }
    }

    public function downloadAll(Request $request) // Jika PDF summary juga perlu
    {
        try {
            // ... (query filter seperti sebelumnya) ...
             $query = JalanPeduliLaporan::with(['pelapor.kecamatan', 'pelapor.kelurahan', 'status', 'kecamatan', 'kelurahan']);

            if ($request->filled('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id_laporan', 'like', $searchTerm)
                      ->orWhereHas('pelapor', function($subQuery) use ($searchTerm) {
                          $subQuery->where('nomor_ponsel', 'like', $searchTerm)
                                   ->orWhere('nama_lengkap', 'like', $searchTerm); 
                      });
                });
            }


            if ($request->filled('status_id')) {
                if ($request->status_id == '_ACCEPT_GROUP_') {
                    $query->whereIn('status_id', self::ACCEPT_STATUS_IDS);
                } elseif (is_numeric($request->status_id)) {
                    $query->where('status_id', $request->status_id);
                }
            }

            $laporans = $query->orderByDesc('created_at')->get();
            $timestamp = time();
            $tempDir = storage_path('app/temp/laporan_all_' . $timestamp);
            // ... (sisa setup direktori) ...
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $pdfPath = $tempDir . '/laporan_summary.pdf';
            try {
                $pdf = Pdf::loadView('admin.pages.jalan-peduli.laporan-masuk.laporan_pdf', [
                    'laporans' => $laporans,
                    'acceptStatusIds' => self::ACCEPT_STATUS_IDS,
                    'pendingStatusId' => self::PENDING_STATUS_ID,
                    'rejectStatusId' => self::REJECT_STATUS_ID,
                    'disposisiStatusId' => self::DISPOSISI_STATUS_ID, // Tambahkan ini
                ]);
                \Log::info('PDF view for all reports loaded successfully');
            } catch (\Exception $e) {
                \Log::warning('View admin.laporan_pdf not found, creating simple PDF: ' . $e->getMessage());
                $html = '<h1>Daftar Laporan</h1>';
                foreach ($laporans as $laporan) {
                    $html .= '<div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ccc;">';
                    $html .= '<h3>Laporan ID: ' . $laporan->id_laporan . '</h3>';
                    $statusText = ($laporan->status) ? ucfirst(str_replace('_', ' ', $laporan->status->nama_status)) : 'N/A';
                    $html .= '<p><strong>Status:</strong> ' . $statusText . '</p>';
                    // Tambahkan keterangan disposisi jika ada
                    if ($laporan->status_id == self::DISPOSISI_STATUS_ID && !empty($laporan->keterangan)) { // DISPOSISI_STATUS_ID masih relevan
                        $html .= '<p><strong>Keterangan Disposisi:</strong> ' . $laporan->keterangan . '</p>';
                    }
                    $html .= '</div>';
                }
                $pdf = Pdf::loadHTML($html);
            }
            $pdf->save($pdfPath);

            // ... (sisa method downloadAll tetap sama) ...
            if (!file_exists($pdfPath)) {
                \Log::error('PDF file was not created at: ' . $pdfPath);
                return redirect()->back()->with('error', 'Gagal membuat file PDF.');
            }
            $photoDir = $tempDir . '/folder_foto';
            if (!file_exists($photoDir)) {
                mkdir($photoDir, 0755, true);
            }
            \Log::info('Processing photos for downloadAll');
            foreach ($laporans as $laporan) {
                $fotoArray = $laporan->foto_kerusakan ? json_decode($laporan->foto_kerusakan, true) : [];
                if (is_array($fotoArray) && !empty($fotoArray)) {
                    foreach ($fotoArray as $index => $foto) {
                        $fotoPath = storage_path('app/public/jalan_peduli/'. $laporan->id_laporan . '/' . $foto);
                        \Log::info('Checking photo path for laporan ' . $laporan->id_laporan . ': ' . $fotoPath);
                        if (file_exists($fotoPath)) {
                            $destination = $photoDir . '/gambar_' . $laporan->id_laporan . '_' . ($index + 1) . '_' . basename($foto);
                            copy($fotoPath, $destination);
                            \Log::info('Copied photo to: ' . $destination);
                        } else {
                            \Log::error('Photo not found at: ' . $fotoPath);
                        }
                    }
                } else {
                    \Log::warning('No photos found or invalid JSON for laporan ID: ' . $laporan->id_laporan);
                }
            }
            $zipPath = storage_path('app/temp/laporan_all_' . $timestamp . '.zip');
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $zip->addFile($pdfPath, 'laporan_summary.pdf'); 
                \Log::info('Added PDF to ZIP: laporan_summary.pdf');
                $files = glob($photoDir . '/*');
                if (!empty($files)) { 
                    foreach ($files as $file) {
                        $zipEntryName = 'folder_foto/' . basename($file); 
                        $zip->addFile($file, $zipEntryName);
                        \Log::info('Added photo to ZIP: ' . $zipEntryName);
                    }
                } else {
                    \Log::warning('No photos to add to ZIP for downloadAll.');
                }
                $zip->close();
                \Log::info('ZIP created at: ' . $zipPath);
            } else {
                \Log::error('Failed to create ZIP file at: ' . $zipPath);
                return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
            }
            if (!file_exists($zipPath)) {
                \Log::error('ZIP file was not created at: ' . $zipPath);
                return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
            }
            $this->deleteDirectory($tempDir);
            return response()->download($zipPath, 'laporan_all.zip')->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Error in downloadAll method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat download: ' . $e->getMessage());
        }
    }
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return;
        }
        if (is_file($dir)) {
            unlink($dir);
            return;
        }
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $this->deleteDirectory("$dir/$file");
        }
        rmdir($dir);
    }
}
