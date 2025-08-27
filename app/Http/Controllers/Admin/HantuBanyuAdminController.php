<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HantuBanyuAdminController extends Controller
{
    public function index()
    {
        $page_title = 'Hantu Banyu';
        $page_description = 'Verifikasi, lihat, tindaklanjuti, atau unduh laporan yang masuk.';

        return view('admin.pages.hantu-banyu.index', [
            'page_title' => $page_title,
            'page_description' => $page_description,
        ]);
    }
}
