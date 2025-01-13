<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PPIDPelaksana;
use App\Models\PPIDPelaksanaKategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PPIDPelaksanaAdminController extends Controller
{
    public function index(Request $request)
    {
        $kategori_id = $request->input('kategori');
        
        $kategori = PPIDPelaksanaKategori::findOrFail($kategori_id);
        $page_title = "PPID Pelaksana - " . $kategori->nama;
        $ppid_pelaksana = PPIDPelaksana::where('id_kategori', $kategori_id)->latest()->get();

        return view('admin.pages.ppid-pelaksana.index', [
            'page_title' => $page_title,
            'ppid_pelaksana' => $ppid_pelaksana,
        ]);
    }

    public function create()
    {
        $page_title = "Tambah PPID Pelaksana";

        return view('admin.pages.ppid-pelaksana.create', [
            'page_title' => $page_title,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file',
            'id_kategori' => 'required|exists:ppid_pelaksana_kategori,id',
        ]);

        $file = $request->file('file');
        $fileName = Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
        $filePath = 'Unduhan/' . now()->format('Y-m/d') . '/' . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($file));

        PPIDPelaksana::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'file' => $filePath,
            'id_kategori' => $request->id_kategori,
        ]);

        return redirect()->route('admin.ppid-pelaksana.index', ['kategori' => $request->id_kategori])->with('success', 'PPID Pelaksana berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page_title = "Edit PPID Pelaksana";
        $ppid_pelaksana = PPIDPelaksana::findOrFail($id);

        return view('admin.pages.ppid-pelaksana.edit', [
            'page_title' => $page_title,
            'ppid_pelaksana' => $ppid_pelaksana,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file',
            'id_kategori' => 'required|exists:ppid_pelaksana_kategori,id',
        ]);

        $ppid_pelaksana = PPIDPelaksana::findOrFail($id);
        $ppid_pelaksana->judul = $request->judul;
        $ppid_pelaksana->slug = Str::slug($request->judul);
        $ppid_pelaksana->id_kategori = $request->id_kategori;

        if ($request->hasFile('file')) {
            // Delete the old file
            if ($ppid_pelaksana->file) {
                Storage::disk('public')->delete($ppid_pelaksana->file);
            }

            $file = $request->file('file');
            $fileName = Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $filePath = 'Unduhan/' . now()->format('Y-m/d') . '/' . $fileName;
            Storage::disk('public')->put($filePath, file_get_contents($file));
            $ppid_pelaksana->file = $filePath;
        }

        $ppid_pelaksana->save();

        return redirect()->route('admin.ppid-pelaksana.index', ['kategori' => $request->id_kategori])->with('success', 'PPID Pelaksana berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ppid_pelaksana = PPIDPelaksana::findOrFail($id);

        // Delete the file
        if ($ppid_pelaksana->file) {
            Storage::disk('public')->delete($ppid_pelaksana->file);
        }

        $ppid_pelaksana->delete();

        return redirect()->route('admin.ppid-pelaksana.index', ['kategori' => $ppid_pelaksana->id_kategori])->with('success', 'PPID Pelaksana berhasil dihapus.');
    }
}
