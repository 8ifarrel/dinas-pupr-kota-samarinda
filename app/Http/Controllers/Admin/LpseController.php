<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LPSE;

class LPSEAdminController extends Controller
{
    public function index()
    {
        $lpses = LPSE::all();
        return view('admin.lpse.index', compact('lpses'));
    }

    public function create()
    {
        return view('admin.lpse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_paket' => 'required',
            'nama_paket' => 'required',
            'jenis_paket' => 'required',
            'url_informasi_paket' => 'required|url',
            'nilai' => 'required|numeric',
        ]);

        LPSE::create($request->all());
        return redirect()->route('admin.lpse.index')->with('success', 'LPSE berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lpse = LPSE::findOrFail($id);
        return view('admin.lpse.edit', compact('lpse'));
    }

    public function update(Request $request, $id)
    {
        $lpse = LPSE::findOrFail($id);
        $lpse->update($request->all());
        return redirect()->route('admin.lpse.index')->with('success', 'LPSE berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lpse = LPSE::findOrFail($id);
        $lpse->delete();
        return redirect()->route('admin.lpse.index')->with('success', 'LPSE berhasil dihapus.');
    }
}