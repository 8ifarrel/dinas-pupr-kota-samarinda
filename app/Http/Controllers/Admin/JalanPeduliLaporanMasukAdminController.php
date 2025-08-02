<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JalanPeduliLaporan;
use App\Models\JalanPeduliStatus;
use Illuminate\Support\Facades\Storage;

class JalanPeduliLaporanMasukAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index(Request $request)
    {
        $page_title = "Jalan Peduli - Laporan Masuk";
        $page_description = "Verifikasi, lihat, atau unduh laporan yang masuk. Laporan yang telah disetujui dapat ditindaklanjuti pada halaman Tindaklanjuti Laporan.";

        // Kategorisasi status
        $pendingStatusId = 1;
        $approvedStatusIds = [2, 3, 4, 5, 6];

        $statusFilter = $request->input('status_id');
        $query = JalanPeduliLaporan::with(['pelapor', 'status', 'kecamatan', 'kelurahan']);

        if ($statusFilter === 'pending') {
            $query->where('status_id', $pendingStatusId);
        } elseif ($statusFilter === 'disetujui') {
            $query->whereIn('status_id', $approvedStatusIds);
        } elseif ($statusFilter) {
            $query->where('status_id', $statusFilter);
        }

        $laporans = $query->orderByDesc('created_at')->get();

        // Statuses untuk filter dropdown
        $statuses = [
            (object)['value' => '', 'label' => 'Semua'],
            (object)['value' => 'pending', 'label' => 'Pending'],
            (object)['value' => 'disetujui', 'label' => 'Disetujui'],
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
        // Setujui laporan: ubah status menjadi "belum_dikerjakan" (status_id = 2)
        $laporan = JalanPeduliLaporan::findOrFail($id);

        // Hanya proses jika status saat ini pending (status_id = 1)
        if ($laporan->status_id != 1) {
            return redirect()->back()->with('error', 'Laporan hanya bisa disetujui jika masih berstatus Pending.');
        }

        $laporan->status_id = 2; // belum_dikerjakan
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
}
