<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Str;

class SusunanOrganisasiAdminController extends Controller
{
    public function index()
    {
        $page_title = "Susunan Organisasi";
        $susunan_organisasi = SusunanOrganisasi::with('parent')
            ->where('id_susunan_organisasi', '!=', 0)
            ->get();

        return view('admin.pages.susunan-organisasi.index', [
            'page_title' => $page_title,
            'susunan_organisasi' => $susunan_organisasi,
        ]);
    }

    public function create()
    {
        $page_title = "Tambah Susunan Organisasi";
        $susunan_organisasi_list = SusunanOrganisasi::all();

        return view('admin.pages.susunan-organisasi.create', [
            'page_title' => $page_title,
            'susunan_organisasi_list' => $susunan_organisasi_list,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi',
            'kelompok_susunan_organisasi' => 'required|string',
        ]);

        $data = $request->all();
        $data['slug_susunan_organisasi'] = Str::slug($request->nama_susunan_organisasi);

        SusunanOrganisasi::create($data);

        return redirect()->route('admin.susunan-organisasi.index')->with('success', 'Susunan Organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page_title = "Edit Susunan Organisasi";
        $susunan = SusunanOrganisasi::findOrFail($id);
        $parentOptions = SusunanOrganisasi::where('id_susunan_organisasi', '!=', $id)->get();

        return view('admin.pages.susunan-organisasi.edit', [
            'page_title' => $page_title,
            'susunan' => $susunan,
            'parentOptions' => $parentOptions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $susunan = SusunanOrganisasi::findOrFail($id);

        $request->validate([
            'nama_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi,nama_susunan_organisasi,' . $id . ',id_susunan_organisasi',
            'kelompok_susunan_organisasi' => 'required|string',
        ]);

        $data = $request->all();
        $data['slug_susunan_organisasi'] = Str::slug($request->nama_susunan_organisasi);

        $susunan->update($data);

        return redirect()->route('admin.susunan-organisasi.index')->with('success', 'Susunan Organisasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $susunan = SusunanOrganisasi::findOrFail($id);
        $susunan->delete();

        return redirect()->route('admin.susunan-organisasi.index')->with('success', 'Susunan Organisasi berhasil dihapus.');
    }
}
