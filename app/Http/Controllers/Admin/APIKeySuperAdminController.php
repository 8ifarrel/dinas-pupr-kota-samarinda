<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Halaman kelola kunci API. Kunci itu sendiri di-CRUD lewat AJAX ke
 * App\Http\Controllers\Api\JalanPeduliApiKeyController /
 * App\Http\Controllers\Api\HantuBanyuApiKeyController (lihat routes/api.php),
 * jadi controller ini hanya bertugas menampilkan halamannya.
 */
class APIKeySuperAdminController extends Controller
{
  public function indexJalanPeduli()
  {
    return view('admin.pages.super-admin.api-key.jalan-peduli.index', [
      'page_title' => 'API Key Jalan Peduli',
      'page_description' => 'Kelola API Key yang digunakan untuk mengirim laporan Jalan Peduli lewat API.',
    ]);
  }

  public function createJalanPeduli()
  {
    return view('admin.pages.super-admin.api-key.jalan-peduli.create', [
      'page_title' => 'Buat API Key Jalan Peduli',
      'page_description' => 'Tambah API Key baru untuk mengakses API Jalan Peduli.',
    ]);
  }

  // Halaman "hantu-banyu" dan "akun-kelurahan" memakai kerangka Blade yang
  // sama (admin.pages.super-admin.api-key.index/create) - lihat berkas itu.
  // Jalan Peduli sengaja tidak ikut, tetap punya berkas Blade sendiri.

  public function indexHantuBanyu()
  {
    return view('admin.pages.super-admin.api-key.index', [
      'provider' => 'hantu-banyu',
      'page_title' => 'API Key Hantu Banyu',
      'page_description' => 'Kelola API Key yang digunakan untuk mengirim laporan Hantu Banyu lewat API.',
    ]);
  }

  public function createHantuBanyu()
  {
    return view('admin.pages.super-admin.api-key.create', [
      'provider' => 'hantu-banyu',
      'page_title' => 'Buat API Key Hantu Banyu',
      'page_description' => 'Tambah API Key baru untuk mengakses API Hantu Banyu.',
    ]);
  }

  public function indexAkunKelurahan()
  {
    return view('admin.pages.super-admin.api-key.index', [
      'provider' => 'akun-kelurahan',
      'page_title' => 'API Key Akun Kelurahan',
      'page_description' => 'Kelola API Key yang digunakan untuk membaca dan memverifikasi akun kelurahan lewat API.',
    ]);
  }

  public function createAkunKelurahan()
  {
    return view('admin.pages.super-admin.api-key.create', [
      'provider' => 'akun-kelurahan',
      'page_title' => 'Buat API Key Akun Kelurahan',
      'page_description' => 'Tambah API Key baru untuk mengakses API akun kelurahan.',
    ]);
  }
}
