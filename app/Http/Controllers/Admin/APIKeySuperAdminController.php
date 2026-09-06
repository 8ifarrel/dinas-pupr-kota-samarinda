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

  public function indexHantuBanyu()
  {
    return view('admin.pages.super-admin.api-key.hantu-banyu.index', [
      'page_title' => 'API Key Hantu Banyu',
      'page_description' => 'Kelola API Key yang digunakan untuk mengirim laporan Hantu Banyu lewat API.',
    ]);
  }

  public function createHantuBanyu()
  {
    return view('admin.pages.super-admin.api-key.hantu-banyu.create', [
      'page_title' => 'Buat API Key Hantu Banyu',
      'page_description' => 'Tambah API Key baru untuk mengakses API Hantu Banyu.',
    ]);
  }

  public function indexSilalad()
  {
    return view('admin.pages.super-admin.api-key.silalad.index', [
      'page_title' => 'API Key SILALAD',
      'page_description' => 'Kelola API Key yang digunakan untuk mendaftarkan dan memantau pesanan SILALAD lewat API.',
    ]);
  }

  public function createSilalad()
  {
    return view('admin.pages.super-admin.api-key.silalad.create', [
      'page_title' => 'Buat API Key SILALAD',
      'page_description' => 'Tambah API Key baru untuk mengakses API SILALAD.',
    ]);
  }

  public function indexAkunKelurahan()
  {
    return view('admin.pages.super-admin.api-key.akun-kelurahan.index', [
      'page_title' => 'API Key Akun Kelurahan',
      'page_description' => 'Kelola API Key yang digunakan untuk membaca dan memverifikasi akun kelurahan lewat API.',
    ]);
  }

  public function createAkunKelurahan()
  {
    return view('admin.pages.super-admin.api-key.akun-kelurahan.create', [
      'page_title' => 'Buat API Key Akun Kelurahan',
      'page_description' => 'Tambah API Key baru untuk mengakses API akun kelurahan.',
    ]);
  }
}
