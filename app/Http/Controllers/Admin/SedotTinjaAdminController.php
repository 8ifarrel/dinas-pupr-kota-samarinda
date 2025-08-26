<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SedotTinja;

class SedotTinjaAdminController extends Controller
{
  /**
   * Menampilkan data laporan Sedot Tinja dalam bentuk table dan statistik
   */
  public function index()
  {
    $page_title = "Sedot Tinja";
    $page_description = "Lihat dan kelola laporan Sedot Tinja yang diadakan oleh Dinas PUPR Kota Samarinda.";

    // TODO: Ambil semua data Sedot Tinja dari database dan kirimkan ke view
  }

  /**
   * Menampilkan form untuk mengedit (memproses) laporan Sedot Tinja
   *
   * @param  int  $id
   */
  public function edit($id)
  {
    $page_title = "Edit Sedot Tinja";
    $page_description = "Proses laporan Sedot Tinja yang diajukan oleh warga.";

    // TODO: Cari data Sedot Tinja berdasarkan ID
    // TODO: Tampilkan form dengan data yang ingin diedit
  }

  /**
   * Memperbarui laporan Sedot Tinja
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   */
  public function update(Request $request, $id)
  {
    // TODO: Validasi data yang dikirim dari form
    // TODO: Update data Sedot Tinja berdasarkan ID
    // TODO: Redirect atau berikan response setelah update
  }

  /**
   * Menampilkan detail laporan Sedot Tinja
   *
   * @param  int  $id
   */
  public function show($id)
  {
    $page_title = "Detail Laporan Sedot Tinja";
    $page_description = "Lihat detail dari laporan Sedot Tinja yang diajukan oleh warga.";

    // TODO: Cari data laporan Sedot Tinja berdasarkan ID
    // TODO: Handle jika data tidak ditemukan
    // TODO: Kirim data ke view untuk ditampilkan
  }

}
