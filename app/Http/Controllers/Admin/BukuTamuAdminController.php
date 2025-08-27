<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use App\Models\BukuTamu;
use Illuminate\Support\Facades\DB;

class BukuTamuAdminController extends Controller
{
    public function index()
    {
        $id_kepala_dinas = 1;
        $jabatan = SusunanOrganisasi::where('id_susunan_organisasi_parent', 1)
            ->where('id_susunan_organisasi', '!=', $id_kepala_dinas)
            ->select('id_susunan_organisasi', 'nama_susunan_organisasi', 'slug_susunan_organisasi')
            ->orderBy('nama_susunan_organisasi')
            ->get();

        $page_title = "Buku Tamu";
        $page_description = "Daftar susunan organisasi untuk pengelolaan antrean buku tamu.";

        return view('admin.buku-tamu.index', [
            'jabatan' => $jabatan,
            'page_title' => $page_title,
            'page_description' => $page_description,
        ]);
    }

    public function show(Request $request, $slug_susunan_organisasi)
    {
        $id_kepala_dinas = 1;
        $susunan = SusunanOrganisasi::where('slug_susunan_organisasi', $slug_susunan_organisasi)
            ->where('id_susunan_organisasi_parent', 1)
            ->where('id_susunan_organisasi', '!=', $id_kepala_dinas)
            ->firstOrFail();

        $filter_hari = $request->query('filter_hari', 'today');
        $query = BukuTamu::where('jabatan_yang_dikunjungi', $susunan->id_susunan_organisasi);

        if ($filter_hari === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        }

        $tamus = $query->orderBy('created_at', 'desc')->get();

        // Cari tamu yang statusnya diterima (hanya satu)
        $tamu_diterima = $tamus->firstWhere('status', 'Diterima');

        $page_title = "Buku Tamu - " . $susunan->nama_susunan_organisasi;
        $page_description = "Daftar antrean tamu untuk " . $susunan->nama_susunan_organisasi . ".";

        return view('admin.buku-tamu.show', [
            'susunan' => $susunan,
            'tamus' => $tamus,
            'filter_hari' => $filter_hari,
            'tamu_diterima' => $tamu_diterima,
            'page_title' => $page_title,
            'page_description' => $page_description,
        ]);
    }

    public function update(Request $request, $slug_susunan_organisasi, $id)
    {
        $request->validate([
            'aksi' => 'required|in:terima,selesai',
            'deskripsi_status' => 'nullable|string|max:255',
        ]);

        $susunan = SusunanOrganisasi::where('slug_susunan_organisasi', $slug_susunan_organisasi)->firstOrFail();
        $tamu = BukuTamu::where('id_buku_tamu', $id)
            ->where('jabatan_yang_dikunjungi', $susunan->id_susunan_organisasi)
            ->firstOrFail();

        if ($request->aksi === 'terima') {
            // Cek apakah sudah ada tamu diterima
            $tamu_diterima = BukuTamu::where('jabatan_yang_dikunjungi', $susunan->id_susunan_organisasi)
                ->where('status', 'Diterima')
                ->where('id_buku_tamu', '!=', $tamu->id_buku_tamu)
                ->whereDate('created_at', now()->toDateString())
                ->first();

            if ($tamu_diterima) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selesaikan tamu dengan nomor antrean ' . $tamu_diterima->nomor_urut . ' terlebih dahulu jika ingin menerima tamu baru.',
                ], 422);
            }

            $tamu->status = 'Diterima';
            $tamu->deskripsi_status = $request->deskripsi_status;
            $tamu->save();

            return response()->json(['success' => true, 'message' => 'Tamu berhasil diterima.']);
        }

        if ($request->aksi === 'selesai') {
            $tamu->status = 'Selesai';
            $tamu->deskripsi_status = $request->deskripsi_status;
            $tamu->save();

            return response()->json(['success' => true, 'message' => 'Tamu berhasil diselesaikan.']);
        }

        return response()->json(['success' => false, 'message' => 'Aksi tidak valid.'], 400);
    }
}