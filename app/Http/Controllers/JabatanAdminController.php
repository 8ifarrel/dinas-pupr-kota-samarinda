<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JabatanAdminController extends Controller
{
    public function index()
    {
        $page_title = "Jabatan";
        $jabatan = Jabatan::with(['children' => function ($query) {
            $query->where('is_subbagian', true)
                  ->orWhere('is_jabatan_fungsional', true);
        }])->where('id_jabatan_parent', 1)->get();
        
        return view('admin.pages.jabatan.index', [
            'jabatan'=> $jabatan,
            'page_title' => $page_title
        ]);
    }

    public function create()
    {
        $page_title = "Tambah Jabatan";
        $jabatanList = Jabatan::all();
        return view('admin.pages.jabatan.create', [
            'page_title'=> $page_title,
            'jabatanList' => $jabatanList
        ]);
    }

    public function store(Request $request)
    {
        // Tentukan parent berdasarkan tipe
        if ($request->is_subbagian) {
            $id_jabatan_parent = $request->subbagian_parent ?: 1;
        } elseif ($request->is_jabatan_fungsional) {
            $id_jabatan_parent = $request->fungsional_parent ?: 1;
        } else {
            $id_jabatan_parent = 1;
        }

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'id_jabatan_parent' => $id_jabatan_parent,
            'slug_jabatan' => Str::slug($request->nama_jabatan),
            'tupoksi_jabatan' => $request->tupoksi_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
            'kelompok_jabatan' => $request->kelompok_jabatan,
            'is_subbagian' => $request->is_subbagian ?? false,
            'is_jabatan_fungsional' => $request->is_jabatan_fungsional ?? false,
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $page_title = "Edit Jabatan";
        $jabatan = Jabatan::findOrFail($id);
        $jabatanList = Jabatan::all();
        return view('admin.pages.jabatan.edit', [
            'jabatan'=> $jabatan,
            'page_title'=> $page_title,
            'jabatanList' => $jabatanList
        ]);
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        if ($request->is_subbagian) {
            $id_jabatan_parent = $request->subbagian_parent ?: 1;
        } elseif ($request->is_jabatan_fungsional) {
            $id_jabatan_parent = $request->fungsional_parent ?: 1;
        } else {
            $id_jabatan_parent = 1;
        }

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
            'id_jabatan_parent' => $id_jabatan_parent,
            'slug_jabatan' => Str::slug($request->nama_jabatan),
            'tupoksi_jabatan' => $request->tupoksi_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
            'kelompok_jabatan' => $request->kelompok_jabatan,
            'is_subbagian' => $request->is_subbagian ?? false,
            'is_jabatan_fungsional' => $request->is_jabatan_fungsional ?? false,
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
