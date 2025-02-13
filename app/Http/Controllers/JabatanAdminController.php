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
            $query->whereRaw("FIND_IN_SET('Subbagian', kelompok_jabatan)")
                  ->orWhereRaw("FIND_IN_SET('Jabatan Fungsional', kelompok_jabatan)");
        }])->where('id_jabatan_parent', 1)->get();
        
        return view('admin.pages.jabatan.index', [
            'jabatan'=> $jabatan,
            'page_title' => $page_title
        ]);
    }

    public function create()
    {
        $page_title = "Tambah Jabatan";
        return view('admin.pages.jabatan.create', [
            'page_title'=> $page_title
        ]);
    }

    public function store(Request $request)
    {
        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'id_jabatan_parent' => 1,
            'slug_jabatan' => Str::slug($request->nama_jabatan),
            'tupoksi_jabatan' => $request->tupoksi_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
            'kelompok_jabatan' => $request->kelompok_jabatan,
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $page_title = "Edit Jabatan";
        $jabatan = Jabatan::findOrFail($id);
        return view('admin.pages.jabatan.edit', [
            'jabatan'=> $jabatan,
            'page_title'=> $page_title
        ]);
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
            'id_jabatan_parent' => 1,
            'slug_jabatan' => Str::slug($request->nama_jabatan),
            'tupoksi_jabatan' => $request->tupoksi_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
            'kelompok_jabatan' => $request->kelompok_jabatan,
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
