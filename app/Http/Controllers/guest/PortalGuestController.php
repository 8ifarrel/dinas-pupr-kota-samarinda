<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortalGuestController extends Controller
{
    public function index() {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Portal";

        return view('guest.pages.portal.index', [
            'meta_description' => $meta_description,
            'page_title' =>$page_title
        ]);
    }
}

