<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;

class SusunanOrganisasiAdminController extends Controller
{
    public function index()
    {
        $page_title = "Susunan Organisasi";
        $susunan = SusunanOrganisasi::with('parent')->get();

        return view('admin.pages.susunan-organisasi.index', [
            'page_title' => $page_title,
            'susunan' => $susunan,
        ]);
    }

    public function create()
    {
        $page_title = "Tambah Susunan Organisasi";
        $parentOptions = SusunanOrganisasi::all();

        return view('admin.pages.susunan-organisasi.create', [
            'page_title' => $page_title,
            'parentOptions' => $parentOptions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi',
            'slug_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi',
            'kelompok_susunan_organisasi' => 'required|string',
        ]);

        SusunanOrganisasi::create($request->all());

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
            'slug_susunan_organisasi' => 'required|string|max:255|unique:susunan_organisasi,slug_susunan_organisasi,' . $id . ',id_susunan_organisasi',
            'kelompok_susunan_organisasi' => 'required|string',
        ]);

        $susunan->update($request->all());

        return redirect()->route('admin.susunan-organisasi.index')->with('success', 'Susunan Organisasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $susunan = SusunanOrganisasi::findOrFail($id);
        $susunan->delete();

        return redirect()->route('admin.susunan-organisasi.index')->with('success', 'Susunan Organisasi berhasil dihapus.');
    }
}
