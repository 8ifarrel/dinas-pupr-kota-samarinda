<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LPSE;

class LPSEAdminController extends Controller
{
    public function index()
    {
        $data = LPSE::orderBy('created_at', 'desc')->get();
        return view('admin.pages.lpse.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pages.lpse.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_paket' => 'required|string|max:255',
            'nama_paket' => 'required|string|max:255',
            'jenis_paket' => 'required|in:tender,nontender,pencatatan non tender,pencatatan swakelola,pencatatan pengadaan darurat',
            'url_informasi_paket' => 'required|url',
            'nilai' => 'required|numeric|min:0',
        ]);

        LPSE::create($validated);

        return redirect()->route('lpse.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $lpse = LPSE::findOrFail($id);
        return view('admin.pages.lpse.edit', compact('lpse'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_paket' => 'required|string|max:255',
            'nama_paket' => 'required|string|max:255',
            'jenis_paket' => 'required|in:tender,nontender,pencatatan non tender,pencatatan swakelola,pencatatan pengadaan darurat',
            'url_informasi_paket' => 'required|url',
            'nilai' => 'required|numeric|min:0',
        ]);

        $lpse = LPSE::findOrFail($id);
        $lpse->update($validated);

        return redirect()->route('lpse.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lpse = LPSE::findOrFail($id);
        $lpse->delete();

        return redirect()->route('lpse.index')->with('success', 'Data berhasil dihapus!');
    }
}