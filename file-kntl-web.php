<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\umum\SKMController;
use App\Http\Controllers\umum\FotoController;
use App\Http\Controllers\umum\HomeController;
use App\Http\Controllers\umum\BeritaController;
use App\Http\Controllers\umum\BidangController;
use App\Http\Controllers\umum\GaleriController;
use App\Http\Controllers\umum\PortalController;
use App\Http\Controllers\umum\ProfileController;
use App\Http\Controllers\umum\NewsboardController;
use App\Http\Controllers\umum\InfografisController;
use App\Http\Controllers\umum\PengumumanController;
use App\Http\Controllers\umum\KontakKamiController;

use App\Http\Controllers\epanel\EPanelFotoController;
use App\Http\Controllers\epanel\EPanelHomeController;
use App\Http\Controllers\epanel\EPanelAdminController;
use App\Http\Controllers\umum\HalamanProfilController;
use App\Http\Controllers\umum\PPIDPelaksanaController;
use App\Http\Controllers\epanel\EPanelBeritaController;
use App\Http\Controllers\epanel\EPanelBidangController;
use App\Http\Controllers\epanel\EPanelGaleriController;
use App\Http\Controllers\epanel\EPanelSliderController;
use App\Http\Controllers\epanel\EPanelTautanController;
use App\Http\Controllers\epanel\EPanelPegawaiController;
use App\Http\Controllers\epanel\EPanelPimpinanController;
use App\Http\Controllers\epanel\EPanelPengumumanController;
use App\Http\Controllers\epanel\EPanelPPIDPelaksanaController;
use App\Http\Controllers\epanel\EPanelAgendaKegiatanController;
use App\Http\Controllers\epanel\EPanelKontakKamiController;

use App\Http\Controllers\ModuleUptd\IndexController as MUIC;
use App\Http\Controllers\ModuleUptd\Admin\TipeLayananController;
use App\Http\Controllers\ModuleUptd\Admin\UserController;
use App\Http\Controllers\ModuleUptd\Admin\IndexController;
use App\Http\Controllers\ModuleUptd\User\LayananController;
use App\Http\Controllers\ModuleUptd\Admin\LaporanController;
use App\Http\Controllers\ModuleUptd\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Comment code ini jika ingin on air
 * Page ini untuk generate password
 */
// Route::get('/jshfkjdsdsvgsh', function () {
//   return view('pwpwp');
// });

/**               
 *     
 * Controller Umum
 *
 */



Route::get('/uptd', [MUIC::class, 'index']);
Route::get('/uptd/layanan/{slug}', [LayananController::class, 'index']);
Route::get('/uptd/layanan/tambah/{slug}', [LayananController::class, 'tambahLaporan']);
Route::post('/uptd/layanan/{slug}', [LayananController::class, 'store']);
Route::get('/uptd/track', [LayananController::class, 'track']);
Route::get('/uptd/login', [AuthController::class, 'loginPage']);
Route::post('/uptd/login', [AuthController::class, 'login']);
Route::get('/uptd/register', [AuthController::class, 'registerPage']);
Route::post('/uptd/register', [AuthController::class, 'register']);


Route::group(['prefix' => '/admin'], function () {
    
    Route::group(['prefix' => '/tipe-layanan'], function () {
        Route::get('/', [TipeLayananController::class, 'index']);
        Route::post('/', [TipeLayananController::class, 'store']);
        Route::get('/{uuid}', [TipeLayananController::class, 'edit']);
        Route::patch('/{uuid}', [TipeLayananController::class, 'update']);
        Route::delete('/{uuid}', [TipeLayananController::class, 'destroy']);
    });

    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{uuid}', [UserController::class, 'edit']);
        Route::patch('/{uuid}', [UserController::class, 'update']);
        Route::delete('/{uuid}', [UserController::class, 'destroy']);
    });

    Route::group(['prefix' => '/layanan'], function () {
        Route::get('/{uuid}', [LaporanController::class, 'index']);
        Route::get('/{uuid}/detail', [LaporanController::class, 'detail']);
        Route::post('/{uuid}/update/{status}', [LaporanController::class, 'update']);
    });

    Route::get('/dboard', [IndexController::class, 'index']);
});


// Portal
Route::get('/', [PortalController::class, 'index'])
  ->name('umum.portal');

// Halaman utama
Route::get('/website', [HomeController::class, 'index'])
  ->name('umum.beranda');

// Kontak kami
Route::get('/kontak-kami', [KontakKamiController::class, 'index'])
  ->name('umum.kontak-kami.index');
Route::post('/kontak-kami', [KontakKamiController::class, 'store'])
  ->name('umum.kontak-kami.store');

// Halaman profil
Route::get('/profil/{page}', [HalamanProfilController::class, 'index'])
  ->name('umum.profil.{page}');

// Bidang
Route::get('/bidang/{namaBidang}', [BidangController::class, 'index'])
  ->name('umum.bidang.{namaBidang}');

// Route::get('/bidang/download/{berkas}', BidangController::class)
//   ->name('umum.download.tupoksi');

Route::get('/storage/bidang/{berkas}/tupoksi.pdf', BidangController::class)
  ->name('umum.download.tupoksi');

// Berita
Route::get('/berita', [BeritaController::class, 'pilih'])
  ->name('umum.berita.pilih');

Route::get('/kategori-berita', [BeritaController::class, 'kategori'])
  ->name('umum.berita.kategori');

Route::get('/berita/{berita:slug}', [BeritaController::class, 'lihat'])
  ->name('umum.berita.lihat.{berita:slug}');

// Infografis
Route::get('/e-library/infografis', [InfografisController::class, 'index'])
  ->name('umum.elibrary.infografis');

// Galeri dan Foto
Route::get('/e-library/galeri', [GaleriController::class, 'index'])
  ->name('umum.elibrary.galeri');

Route::get('/e-library/galeri/{media_album:slug}', [FotoController::class, 'index'])
  ->name('umum.elibrary.foto.{media_album:slug}');

// Video
Route::get('/e-library/video', function () {
  return view('umum.pages.e-library.video');
})->name('umum.elibrary.video');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])
  ->name('umum.pengumuman');

// PPID Pelaksana
Route::get('/ppid-pelaksana/{kategori:slug}', [PPIDPelaksanaController::class, 'index'])
  ->name('umum.ppid-pelaksana.{kategori:slug}');

Route::get('/ppid-pelaksana/download/{berkas}', PPIDPelaksanaController::class)
  ->name('umum.ppid-pelaksana.download.{berkas}');

// SKM
Route::get('/skm', [SKMController::class, 'index'])
  ->name('umum.skm.index');

Route::post('/skm', [SKMController::class, 'store'])
  ->name('umum.skm.kirim');

// Aplikasi Parit
Route::get('/program/aplikasi-parit', function () {
  return view('umum.program.aplikasi-parit');
});

// Video
Route::get('/program/uptd-jalan', function () {
  return view('umum.program.uptd-jalan');
});

// Agenda selengkapnya
Route::get('/agenda-selengkapnya', function () {
  return view('umum.pages.agenda-selengkapnya');
});

// Newsboard
Route::get('/newsboard', [NewsboardController::class, 'index'])
  ->name('umum.newsboard');

/**
 * 
 * Controller E-Panel (admin biasa)
 * 
 */

Route::middleware(['auth'])->group(function () {
  // Beranda
  Route::get('/epanel', [EPanelHomeController::class, 'index'])
    ->name('epanel.beranda');

  // Display Kontak Kami
  Route::get('epanel/kontak-kami', [EPanelKontakKamiController::class, 'index'])
    ->name('epanel.kontak-kami.index');

  // Kategori Berita
  Route::get('/epanel/kategori-berita', [EPanelBeritaController::class, 'kategori'])
    ->name('epanel.berita.kategori');

  // Display Berita
  Route::get('epanel/berita/', [EPanelBeritaController::class, 'pilih'])
    ->name('epanel.berita.pilih');

  // Create and Store Berita
  Route::get('/epanel/berita/tambah', [EPanelBeritaController::class, 'create'])
    ->name('epanel.berita.create');

  Route::post('/epanel/berita', [EPanelBeritaController::class, 'store'])
    ->name('epanel.berita.store');

  // Edit and Update Berita
  Route::get('epanel/berita/edit/{uuid}', [EPanelBeritaController::class, 'edit'])
    ->name('epanel.berita.edit');

  Route::put('epanel/berita/{uuid}', [EPanelBeritaController::class, 'update'])
    ->name('epanel.berita.update');

  // Remove Berita
  Route::delete('epanel/berita/{uuid}', [EPanelBeritaController::class, 'destroy'])
    ->name('epanel.berita.destroy');

  // Kategori PPID Pelaksana
  Route::get('/epanel/kategori-ppid-pelaksana', [EPanelPPIDPelaksanaController::class, 'kategori'])
    ->name('epanel.ppid-pelaksana.kategori');

  // Display PPID Pelaksana
  Route::get('epanel/ppid-pelaksana/', [EPanelPPIDPelaksanaController::class, 'pilih'])
    ->name('epanel.ppid-pelaksana.pilih');

  // Create and Store PPID Pelaksana
  Route::get('/epanel/ppid-pelaksana/tambah', [EPanelPPIDPelaksanaController::class, 'create'])
    ->name('epanel.ppid-pelaksana.create');

  Route::post('/epanel/ppid-pelaksana', [EPanelPPIDPelaksanaController::class, 'store'])
    ->name('epanel.ppid-pelaksana.store');

  // Edit and Update PPID Pelaksana
  Route::get('epanel/ppid-pelaksana/edit/{uuid}', [EPanelPPIDPelaksanaController::class, 'edit'])
    ->name('epanel.ppid-pelaksana.edit');

  Route::put('epanel/ppid-pelaksana/{uuid}', [EPanelPPIDPelaksanaController::class, 'update'])
    ->name('epanel.ppid-pelaksana.update');

  // Remove PPID Pelaksana
  Route::delete('epanel/ppid-pelaksana/{uuid}', [EPanelPPIDPelaksanaController::class, 'destroy'])
    ->name('epanel.ppid-pelaksana.destroy');

  // Display Galeri
  Route::get('/epanel/galeri', [EPanelGaleriController::class, 'display'])
    ->name('epanel.galeri');

  // Create and Store Galeri
  Route::get('/epanel/galeri/tambah', [EPanelGaleriController::class, 'create'])
    ->name('epanel.galeri.create');

  Route::post('/epanel/galeri', [EPanelGaleriController::class, 'store'])
    ->name('epanel.galeri.store');

  // Edit and Update Galeri
  Route::get('epanel/galeri/edit/{uuid}', [EPanelGaleriController::class, 'edit'])
    ->name('epanel.galeri.edit');

  Route::put('epanel/galeri/{uuid}', [EPanelGaleriController::class, 'update'])
    ->name('epanel.galeri.update');

  // Foto
  Route::get('epanel/foto', [EPanelFotoController::class, 'display'])
    ->name('epanel.foto.pilih');

  // Create and Store Foto
  Route::get('/epanel/foto/tambah', [EPanelFotoController::class, 'create'])
    ->name('epanel.foto.create');

  Route::post('/epanel/foto', [EPanelFotoController::class, 'store'])
    ->name('epanel.foto.store');

  // Edit and Update Foto
  Route::get('epanel/foto/edit/{uuid}', [EPanelFotoController::class, 'edit'])
    ->name('epanel.foto.edit');

  Route::put('epanel/foto/{uuid}', [EPanelFotoController::class, 'update'])
    ->name('epanel.foto.update');

  // Remove Galeri
  Route::delete('epanel/galeri/{uuid}', [EPanelGaleriController::class, 'destroy'])
    ->name('epanel.galeri.destroy');

  // Remove Foto
  Route::delete('epanel/foto/{uuid}', [EPanelFotoController::class, 'destroy'])
    ->name('epanel.foto.destroy');

  // Display Agenda Kegiatan
  Route::get('epanel/agenda-kegiatan/', [EPanelAgendaKegiatanController::class, 'index'])
    ->name('epanel.agenda-kegiatan.index');

  // Create and Store Agenda Kegiatan
  Route::get('/epanel/agenda-kegiatan/tambah', [EPanelAgendaKegiatanController::class, 'create'])
    ->name('epanel.agenda-kegiatan.create');

  Route::post('/epanel/agenda-kegiatan/store', [EPanelAgendaKegiatanController::class, 'store'])
    ->name('epanel.agenda-kegiatan.store');

  // Edit and Update Agenda Kegiatan
  Route::get('epanel/agenda-kegiatan/edit/{uuid}', [EPanelAgendaKegiatanController::class, 'edit'])
    ->name('epanel.agenda-kegiatan.edit');

  Route::put('epanel/agenda-kegiatan/{uuid}', [EPanelAgendaKegiatanController::class, 'update'])
    ->name('epanel.agenda-kegiatan.update');

  // Remove Agenda Kegiatan
  Route::delete('epanel/agenda-kegiatan/{uuid}', [EPanelAgendaKegiatanController::class, 'destroy'])
    ->name('epanel.agenda-kegiatan.destroy');

  // Display Pengumuman
  Route::get('epanel/pengumuman/', [EPanelPengumumanController::class, 'index'])
    ->name('epanel.pengumuman.index');

  // Create and Store Pengumuman
  Route::get('/epanel/pengumuman/tambah', [EPanelPengumumanController::class, 'create'])
    ->name('epanel.pengumuman.create');

  Route::post('/epanel/agenda-kegiatan', [EPanelPengumumanController::class, 'store'])
    ->name('epanel.pengumuman.store');

  // Edit and Update Pengumuman
  Route::get('epanel/pengumuman/edit/{uuid}', [EPanelPengumumanController::class, 'edit'])
    ->name('epanel.pengumuman.edit');

  Route::put('epanel/pengumuman/{uuid}', [EPanelPengumumanController::class, 'update'])
    ->name('epanel.pengumuman.update');

  // Remove Pengumuman
  Route::delete('epanel/pengumuman/{uuid}', [EPanelPengumumanController::class, 'destroy'])
    ->name('epanel.pengumuman.destroy');
});

/**
 * 
 * Controller E-Panel (superadmin)
 * 
 */
Route::middleware(['auth', 'superadmin'])->group(function () {
  // Display Slider
  Route::get('/epanel/slider', [EPanelSliderController::class, 'index'])
    ->name('epanel.slider.index');

  // Create and Store Slider
  Route::get('/epanel/slider/tambah', [EPanelSliderController::class, 'create'])
    ->name('epanel.slider.create');

  Route::post('/epanel/slider', [EPanelSliderController::class, 'store'])
    ->name('epanel.slider.store');

  // Edit and Update Slider
  Route::get('/epanel/slider/edit/{uuid}', [EPanelSliderController::class, 'edit'])
    ->name('epanel.slider.edit');

  Route::put('/epanel/slider/{uuid}', [EPanelSliderController::class, 'update'])
    ->name('epanel.slider.update');

  // Remove Slider
  Route::delete('/epanel/slider/{uuid}', [EPanelSliderController::class, 'destroy'])
    ->name('epanel.slider.destroy');

  // Display Tautan
  Route::get('/epanel/tautan', [EPanelTautanController::class, 'index'])
    ->name('epanel.tautan.index');

  // Create and Store Tautan
  Route::get('/epanel/tautan/tambah', [EPanelTautanController::class, 'create'])
    ->name('epanel.tautan.create');

  Route::post('/epanel/tautan', [EPanelTautanController::class, 'store'])
    ->name('epanel.tautan.store');

  // Edit and Update Tautan
  Route::get('/epanel/tautan/edit/{uuid}', [EPanelTautanController::class, 'edit'])
    ->name('epanel.tautan.edit');

  Route::put('/epanel/tautan/{uuid}', [EPanelTautanController::class, 'update'])
    ->name('epanel.tautan.update');

  // Remove Tautan
  Route::delete('/epanel/tautan/{uuid}', [EPanelTautanController::class, 'destroy'])
    ->name('epanel.tautan.destroy');

  // Edit and Update Pimpinan
  Route::get('epanel/pimpinan/edit', [EPanelPimpinanController::class, 'edit'])
    ->name('epanel.pimpinan.edit');

  Route::put('epanel/pimpinan/update', [EPanelPimpinanController::class, 'update'])
    ->name('epanel.pimpinan.update');

  // Display Pegawai
  Route::get('/epanel/pegawai', [EPanelPegawaiController::class, 'index'])
    ->name('epanel.pegawai.index');

  // Create and Store Pegawai
  Route::get('/epanel/pegawai/tambah', [EPanelPegawaiController::class, 'create'])
    ->name('epanel.pegawai.create');

  Route::post('/epanel/pegawai', [EPanelPegawaiController::class, 'store'])
    ->name('epanel.pegawai.store');

  // Edit and Update Pegawai
  Route::get('/epanel/pegawai/edit/{uuid}', [EPanelPegawaiController::class, 'edit'])
    ->name('epanel.pegawai.edit');

  Route::put('/epanel/pegawai/{uuid}', [EPanelPegawaiController::class, 'update'])
    ->name('epanel.pegawai.update');

  // Remove Pegawai
  Route::delete('/epanel/pegawai/{uuid}', [EPanelPegawaiController::class, 'destroy'])
    ->name('epanel.pegawai.destroy');

  // Display Bidang
  Route::get('/epanel/bidang', [EPanelBidangController::class, 'index'])
    ->name('epanel.bidang.index');

  // Create and Store Bidang
  Route::get('/epanel/bidang/tambah', [EPanelBidangController::class, 'create'])
    ->name('epanel.bidang.create');

  Route::post('/epanel/bidang', [EPanelBidangController::class, 'store'])
    ->name('epanel.bidang.store');

  // Edit and Update Bidang
  Route::get('/epanel/bidang/edit/{uuid}', [EPanelBidangController::class, 'edit'])
    ->name('epanel.bidang.edit');

  Route::put('/epanel/bidang/{uuid}', [EPanelBidangController::class, 'update'])
    ->name('epanel.bidang.update');

  // Remove Bidang
  Route::delete('/epanel/bidang/{uuid}', [EPanelBidangController::class, 'destroy'])
    ->name('epanel.bidang.destroy');

  // Display Akun Admin
  Route::get('/epanel/akun-admin/', [EPanelAdminController::class, 'index'])
    ->name('epanel.akun-admin.index');

  // Create and Store Bidang
  Route::get('/epanel/akun-admin/tambah', [EPanelAdminController::class, 'create'])
    ->name('epanel.akun-admin.create');

  Route::post('/epanel/akun-admin', [EPanelAdminController::class, 'store'])
    ->name('epanel.akun-admin.store');

  // Edit dan Update Akun Admin
  Route::get('/epanel/akun-admin/edit/{uuid}', [EPanelAdminController::class, 'edit'])
    ->name('epanel.akun-admin.edit');

  Route::put('/epanel/akun-admin/{uuid}', [EPanelAdminController::class, 'update'])
    ->name('epanel.akun-admin.update');

  // Hapus Akun Admin
  Route::delete('/epanel/akun-admin/{uuid}', [EPanelAdminController::class, 'destroy'])
    ->name('epanel.akun-admin.destroy');
});

require __DIR__ . '/auth.php';
