<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanAdminController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->get();
        $page_title = "Pengumuman";

        return view('admin.pages.pengumuman.index', [
            'pengumuman'=> $pengumuman,
            'page_title'=> $page_title,
        ]);
    }

    public function create()
    {
        $page_title = "Pengumuman";

        return view('admin.pages.pengumuman.create', [
            'page_title'=> $page_title,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'perihal' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $slug = Str::slug($request->judul_pengumuman);
        $fileLampiranPath = null;
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = $slug . '.' . $file->getClientOriginalExtension();
            $fileLampiranPath = Storage::disk('public')->putFileAs('Pengumuman', $file, $fileName);
        }

        Pengumuman::create([
            'judul_pengumuman' => $request->judul_pengumuman,
            'slug_pengumuman' => $slug,
            'perihal' => $request->perihal,
            'file_lampiran' => $fileLampiranPath,
            'views_count' => 0,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $page_title = "Edit Pengumuman";

        return view('admin.pages.pengumuman.edit', [
            'pengumuman' => $pengumuman,
            'page_title' => $page_title,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'perihal' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $slug = Str::slug($request->judul_pengumuman);
        $fileLampiranPath = $pengumuman->file_lampiran;

        if ($request->hasFile('file_lampiran')) {
            if ($fileLampiranPath) {
                Storage::disk('public')->delete($fileLampiranPath);
            }

            $file = $request->file('file_lampiran');
            $fileName = $slug . '.' . $file->getClientOriginalExtension();
            $fileLampiranPath = Storage::disk('public')->putFileAs('Pengumuman', $file, $fileName);
        }

        $pengumuman->update([
            'judul_pengumuman' => $request->judul_pengumuman,
            'slug_pengumuman' => $slug,
            'perihal' => $request->perihal,
            'file_lampiran' => $fileLampiranPath,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->file_lampiran) {
            Storage::disk('public')->delete($pengumuman->file_lampiran);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
