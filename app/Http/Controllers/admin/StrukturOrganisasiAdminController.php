<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasiDiagram;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Str;

class StrukturOrganisasiAdminController extends Controller
{
    public function index()
    {
        $page_title = "Struktur Organisasi";
        $susunan_organisasi = SusunanOrganisasi::with('parent')
            ->where('id_susunan_organisasi', '!=', 0)
            ->get();
        $organigram = StrukturOrganisasiDiagram::select('diagram_struktur_organisasi')
            ->whereNull('id_struktur_organisasi')
            ->first();

        return view('admin.pages.struktur-organisasi.index', [
            'page_title' => $page_title,
            'susunan_organisasi' => $susunan_organisasi,
            'organigram' => $organigram,
        ]);
    }
}
