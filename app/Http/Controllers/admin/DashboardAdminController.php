<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index() {
        $page_title = "Dashboard";

        return view('admin.pages.dashboard.index', [
            'page_title' => $page_title,
        ]);
    }
}