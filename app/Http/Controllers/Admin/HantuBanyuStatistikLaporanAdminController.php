<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HantuBanyu\StatistikLaporan;

/**
 * Statistik laporan Hantu Banyu untuk E-Panel, mencakup seluruh kelurahan.
 */
class HantuBanyuStatistikLaporanAdminController extends Controller
{
  public function index()
  {
    return view('admin.pages.hantu-banyu.statistik-laporan.index', array_merge(
      StatistikLaporan::compute(),
      [
        'page_title' => 'Statistik Laporan Hantu Banyu',
        'page_description' => 'Ringkasan kinerja penanganan pengaduan drainase dan irigasi.',
      ]
    ));
  }
}
