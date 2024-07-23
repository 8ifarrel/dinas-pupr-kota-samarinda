<?php

use Illuminate\Support\Facades\Route;

/**
 * Guest 
 */

use App\Http\Controllers\guest\PortalGuestController;
use App\Http\Controllers\guest\BerandaGuestController;
use App\Http\Controllers\guest\ProfilKepalaDinasGuestController;
use App\Http\Controllers\guest\SejarahKotaSamarindaGuestController;
use App\Http\Controllers\guest\SejarahDinasPUPRKotaSamarindaGuestController;
use App\Http\Controllers\guest\StrukturOrganisasiGuestController;
use App\Http\Controllers\guest\VisiDanMisiGuestController;
use App\Http\Controllers\guest\BeritaGuestController;
use App\Http\Controllers\guest\BeritaKategoriGuestController;

Route::get('/', [PortalGuestController::class, 'index'])
	->name('guest.portal.index');

Route::get('/beranda', [BerandaGuestController::class, 'index'])
	->name('guest.beranda.index');

Route::get('/profil/profil-kepala-dinas', [ProfilKepalaDinasGuestController::class, 'index'])
	->name('guest.profil.profil-kepala-dinas.index');

Route::get('/profil/sejarah-kota-samarinda', [SejarahKotaSamarindaGuestController::class, 'index'])
	->name('guest.profil.sejarah-kota-samarinda.index');

Route::get('/profil/sejarah-dinas-pupr-kota-samarinda', [SejarahDinasPUPRKotaSamarindaGuestController::class, 'index'])
	->name('guest.profil.sejarah-dinas-pupr-kota-samarinda.index');

Route::get('/profil/visi-dan-misi', [VisiDanMisiGuestController::class, 'index'])
	->name('guest.profil.visi-dan-misi.index');

Route::get('/profil/struktur-organisasi', [StrukturOrganisasiGuestController::class, 'index'])
	->name('guest.profil.struktur-organisasi.index');

Route::get('/berita/kategori', [BeritaKategoriGuestController::class, 'index'])
	->name('guest.berita.kategori.index');

Route::get('/berita/kategori/{slug_kategori}', [BeritaKategoriGuestController::class, 'show'])
	->where('slug_kategori', '[A-Za-z\-]+')
	->name('guest.berita.kategori.show');

Route::get('/berita/kategori/{slug_kategori}/search', [BeritaKategoriGuestController::class, 'search'])
	->where('slug_kategori', '[A-Za-z\-]+')
	->name('guest.berita.kategori.search');

Route::get('/berita/{nama_berita}', [BeritaGuestController::class, 'show'])
	->where('uuid_berita', '[0-9a-fA-F\-]{36}')
	->name('guest.berita.show');

Route::get('/login', function() {
	return view('admin.pages.login.index');
});
