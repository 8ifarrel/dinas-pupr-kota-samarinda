<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JalanPeduliLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JalanPeduliTindaklanjutiLaporanAdminController extends Controller
{
    /**
     * Menampilkan data Jalan Peduli yang ada di sistem.
     */
    public function index(Request $request)
    {
        $page_title = "Jalan Peduli - Tindaklanjuti Laporan";
        $page_description = "Tindaklanjuti laporan masuk yang telah disetujui untuk mencatat perkembangan penanganan jalan rusak";

        $query = JalanPeduliLaporan::with(['status', 'kecamatan', 'kelurahan']);

        $excludeStatus = ['pending', 'reject'];
        $query->whereHas('status', function ($q) use ($excludeStatus) {
            $q->whereNotIn('nama_status', $excludeStatus);
        });

        if ($request->filled('search') ) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id_laporan', 'like', "%{$search}%")
                    ->orWhere('nomor_ponsel', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tingkat_kerusakan_filter')) {
            $query->where('tingkat_kerusakan', $request->input('tingkat_kerusakan_filter'));
        }
        if ($request->filled('jenis_kerusakan_filter')) {
            $query->where('jenis_kerusakan', $request->input('jenis_kerusakan_filter'));
        }
        if ($request->filled('status_kerusakan_filter')) {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('nama_status', $request->input('status_kerusakan_filter'));
            });
        }

        // Ambil semua status dari tabel untuk mapping label/warna di view
        $allStatuses = \App\Models\JalanPeduliStatus::all();

        // Jika request map=1, return JSON untuk peta
        if ($request->has('map')) {
            $laporans = $query->get();
            return response()->json($laporans);
        }

        $laporans = $query->orderByDesc('created_at')->paginate(6);

        return view('admin.pages.jalan-peduli.tindaklanjuti-laporan.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'laporans' => $laporans,
            'allStatuses' => $allStatuses,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit data Jalan Peduli berdasarkan ID.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $page_title = "Jalan Peduli - Edit Laporan";
        $page_description = "Catat perkembangan penanganan laporan masuk dengan ID $id";

        $laporan = JalanPeduliLaporan::with(['kecamatan', 'kelurahan', 'status'])
            ->where('id_laporan', $id)
            ->firstOrFail();

        return view('admin.pages.jalan-peduli.tindaklanjuti-laporan.edit', [
            'page_title' => $page_title,
            'page_description' => $page_description,
            'laporan' => $laporan,
        ]);
    }

    /**
     * Memperbarui data Jalan Peduli berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $laporan = JalanPeduliLaporan::findOrFail($id);

        $request->validate([
            'status_id'        => 'required|exists:jalan_peduli_status,status_id',
            'keterangan'       => 'nullable|string',
            'jenis_kerusakan'  => 'nullable|string|max:255',
            'tingkat_kerusakan'=> 'nullable|string|max:255',
            'foto_lanjutan'    => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'dokumen_petugas'  => 'nullable|file|mimes:pdf,doc,docx|max:10240', 
        ]);

        if ($request->hasFile('foto_lanjutan')) {
            $file = $request->file('foto_lanjutan');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto_lanjutan', $filename, 'public');
            $laporan->foto_lanjutan = $filename;
        }

        if ($request->hasFile('dokumen_petugas')) {
            $file = $request->file('dokumen_petugas');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen_petugas', $filename, 'public');
            $laporan->dokumen_petugas = $filename;
        }

        $laporan->status_id = $request->status_id;
        $laporan->keterangan = $request->keterangan;
        $laporan->jenis_kerusakan = $request->jenis_kerusakan;
        $laporan->tingkat_kerusakan = $request->tingkat_kerusakan;

        $laporan->save();

        return redirect()->route('admin.jalan-peduli.tindaklanjuti-laporan.index')->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Menghapus data laporan dari database berdasarkan ID.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $laporan = JalanPeduliLaporan::findOrFail($id);
        $photos = json_decode($laporan->foto_kerusakan, true) ?? [];
        foreach ($photos as $photo) {
            Storage::disk('public')->delete('jalan_peduli/' . $laporan->id_laporan . '/' . $photo);
        }
        if ($laporan->foto_lanjutan) {
            Storage::disk('public')->delete('foto_lanjutan/' . $laporan->foto_lanjutan);
        }
        if ($laporan->dokumen_petugas) {
            Storage::disk('public')->delete('dokumen_petugas/' . $laporan->dokumen_petugas);
        }
        $laporan->delete();
        return redirect()->route('admin.jalan-peduli.tindaklanjuti-laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}

