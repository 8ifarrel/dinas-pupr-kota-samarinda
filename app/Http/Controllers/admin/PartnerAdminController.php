<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PartnerAdminController extends Controller
{
    public function index()
    {
        $page_title = "Partner";
        $partners = Partner::all();

        return view('admin.pages.partner.index', [
            'page_title' => $page_title,
            'partners' => $partners,
        ]);
    }

    public function create()
    {
        $page_title = "Tambah Partner";

        return view('admin.pages.partner.create', [
            'page_title' => $page_title,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_partner' => 'required|string|max:255',
            'url_partner' => 'required|url|max:255',
            'foto_partner' => 'required|string',
        ]);

        $partner = new Partner();
        $partner->nama_partner = $request->input('nama_partner');
        $partner->url_partner = $request->input('url_partner');

        $fotoPartnerData = json_decode($request->input('foto_partner'), true);
        if (isset($fotoPartnerData['fileUrl'])) {
            $tempFilePath = str_replace('/storage/', '', $fotoPartnerData['fileUrl']);
            $nextId = DB::select("SHOW TABLE STATUS LIKE 'partner'")[0]->Auto_increment;
            $newFileName = 'Partner/' . $nextId . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
            Storage::disk('public')->move($tempFilePath, $newFileName);
            $partner->foto_partner = $newFileName;
        }

        $partner->save();

        return redirect()->route('admin.partner.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page_title = "Edit Partner";
        $partner = Partner::findOrFail($id);

        return view('admin.pages.partner.edit', [
            'page_title' => $page_title,
            'partner' => $partner,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_partner' => 'required|string|max:255',
            'url_partner' => 'required|url|max:255',
            'foto_partner' => 'nullable|string',
        ]);

        $partner = Partner::findOrFail($id);
        $partner->nama_partner = $request->input('nama_partner');
        $partner->url_partner = $request->input('url_partner');

        if ($request->has('foto_partner')) {
            $fotoPartnerData = json_decode($request->input('foto_partner'), true);
            if (isset($fotoPartnerData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoPartnerData['fileUrl']);
                $newFileName = 'Partner/' . $partner->id_partner . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $newFileName);
                $partner->foto_partner = $newFileName;
            }
        }

        $partner->save();

        return redirect()->route('admin.partner.index')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        if (Storage::disk('public')->exists($partner->foto_partner)) {
            Storage::disk('public')->delete($partner->foto_partner);
        }

        $partner->delete();

        return redirect()->route('admin.partner.index')->with('success', 'Partner berhasil dihapus.');
    }
}
