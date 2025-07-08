<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Additional Route
|--------------------------------------------------------------------------
|
| Rute-rute berikut	digunakan untuk keperluan tambahan yang digunakan pada 
| Halaman Admin (E-Panel) dan Halaman Guest
|
*/

use App\Http\Controllers\FilePondController;

/**
 * FilePond
 */

Route::prefix('filepond')->group(function () {
	Route::post('/process', [FilePondController::class, 'process'])
		->name('filepond.process');

	Route::delete('/revert', [FilePondController::class, 'revert'])
		->name('filepond.revert');
});

/*
|--------------------------------------------------------------------------
| Halaman Guest
|--------------------------------------------------------------------------
|
| Rute-rute berikut dikhususkan untuk pengunjung umum yang mengakses
| website ini
|
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
use App\Http\Controllers\guest\PengumumanGuestController;
use App\Http\Controllers\guest\BukuTamuGuestController;
use App\Http\Controllers\guest\PPIDPelaksanaKategoriGuestController;
use App\Http\Controllers\guest\PPIDPelaksanaGuestController;

/**
 * Portal
 */

Route::get('/', [PortalGuestController::class, 'index'])
	->name('guest.portal.index');

/**
 * Beranda
 */

Route::get('/beranda', [BerandaGuestController::class, 'index'])
	->name('guest.beranda.index');

/**
 * Profil
 */

Route::prefix('profil')->group(function () {
	Route::get('/profil-kepala-dinas', [ProfilKepalaDinasGuestController::class, 'index'])
		->name('guest.profil.profil-kepala-dinas.index');

	Route::get('/sejarah-kota-samarinda', [SejarahKotaSamarindaGuestController::class, 'index'])
		->name('guest.profil.sejarah-kota-samarinda.index');

	Route::get('/sejarah-dinas-pupr-kota-samarinda', [SejarahDinasPUPRKotaSamarindaGuestController::class, 'index'])
		->name('guest.profil.sejarah-dinas-pupr-kota-samarinda.index');

	Route::get('/visi-dan-misi', [VisiDanMisiGuestController::class, 'index'])
		->name('guest.profil.visi-dan-misi.index');

	Route::prefix('struktur-organisasi')->group(function () {
		Route::get('/', [StrukturOrganisasiGuestController::class, 'index'])
			->name('guest.profil.struktur-organisasi.index');

		Route::get('/{slug_susunan_organisasi}', [StrukturOrganisasiGuestController::class, 'show'])
			->name('guest.profil.struktur-organisasi.show');
	});
});

/**
 * Berita
 */

Route::prefix('berita')->group(function () {
	Route::get('/kategori', [BeritaKategoriGuestController::class, 'index'])
		->name('guest.berita.kategori.index');

	Route::get('/kategori/{slug_kategori}', [BeritaKategoriGuestController::class, 'show'])
		->name('guest.berita.kategori.show');

	Route::get('/kategori/{slug_kategori}/search', [BeritaKategoriGuestController::class, 'search'])
		->name('guest.berita.kategori.search');

	Route::get('/{slug_berita}', [BeritaGuestController::class, 'show'])
		->name('guest.berita.show');
});


/**
 * Pengumuman
 */
Route::prefix('pengumuman')->group(callback: function () {
	Route::get('/', [PengumumanGuestController::class, 'index'])
		->name('guest.pengumuman.index');
	Route::post('/store/{slug}', [PengumumanGuestController::class, 'store'])
		->name('guest.pengumuman.store');
	Route::get('/download/{slug}', [PengumumanGuestController::class, 'download'])
		->name('guest.pengumuman.download');
});

/**
 * PPID Pelaksana
 */

Route::prefix('ppid-pelaksana')->group(callback: function () {
	Route::get('/kategori', [PPIDPelaksanaKategoriGuestController::class, 'index'])
		->name('guest.ppid-pelaksana.kategori.index');
	Route::get('/kategori/{slug}', [PPIDPelaksanaKategoriGuestController::class, 'show'])
		->name('guest.ppid-pelaksana.kategori.show');
	// Tambahkan route download
	Route::get('/download/{id}', [PPIDPelaksanaGuestController::class, 'download'])
		->name('guest.ppid-pelaksana.download');
});

/**
 * E-Library
 */

Route::get('/e-library/galeri-foto', function () {
	abort(503, 'Halaman ini sedang dalam pembaharuan');
})->name('guest.e-library.galeri-foto.index');

Route::get('/e-library/video', function () {
	abort(503, 'Halaman ini sedang dalam pembaharuan');
})->name('guest.e-library.video.index');

/**
 * Agenda Kegiatan
 */

Route::get('/agenda-kegiatan', function () {
	abort(503, 'Halaman ini sedang dalam pembaharuan');
})->name('guest.agenda-kegiatan.index');

/**
 * SKM
 */

Route::get('/skm', function () {
	abort(503, 'Halaman ini sedang dalam pembaharuan');
})->name('guest.skm.index');

/**
 * Buku Tamu
 */

Route::prefix('buku-tamu')->group(function () {
	Route::get('/', [BukuTamuGuestController::class, 'index'])
		->name('guest.buku-tamu.index');

	Route::get('/daftar', [BukuTamuGuestController::class, 'create'])
		->name('guest.buku-tamu.create');

	Route::post('/daftar', [BukuTamuGuestController::class, 'store'])
		->name('guest.buku-tamu.store');

	Route::get('/hasil', [BukuTamuGuestController::class, 'result'])
		->name('guest.buku-tamu.result');

	Route::get('/status', [BukuTamuGuestController::class, 'show'])
		->name('guest.buku-tamu.show');
});


/*
|--------------------------------------------------------------------------
| Halaman Admin (E-Panel)
|--------------------------------------------------------------------------
|
| Rute-rute berikut dikhususkan untuk administrator yang memiliki akses 
| penuh ke fitur dan pengelolaan website. Halaman ini hanya digunakan 
| untuk keperluan manajemen dan pengaturan internal.
|
*/

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Http\Middleware\IsSuperAdmin;

use App\Http\Controllers\admin\LoginAdminController;
use App\Http\Controllers\admin\DashboardAdminController;
use App\Http\Controllers\admin\SliderAdminController;
use App\Http\Controllers\admin\PartnerAdminController;
use App\Http\Controllers\admin\BeritaKategoriAdminController;
use App\Http\Controllers\admin\BeritaAdminController;
use App\Http\Controllers\admin\PPIDPelaksanaKategoriAdminController;
use App\Http\Controllers\admin\PengumumanAdminController;
use App\Http\Controllers\admin\PPIDPelaksanaAdminController;
use App\Http\Controllers\admin\SusunanOrganisasiAdminController;
use App\Http\Controllers\admin\KepalaDinasAdminController;
use App\Http\Controllers\admin\VisiDanMisiAdminController;
use App\Http\Controllers\admin\SejarahDinasPUPRKotaSamarindaAdminController;
use App\Http\Controllers\admin\StrukturOrganisasiAdminController;
use App\Http\Controllers\admin\OrganigramAdminController;

use App\Http\Controllers\admin\AkunAdminSuperAdminController;

Route::prefix('e-panel')->group(function () {
	Route::middleware([RedirectIfAuthenticated::class])->group(function () {
		/**
		 * Login
		 */
		Route::get('/login', [LoginAdminController::class, 'index'])
			->name('admin.login.index');
		Route::post('/login', [LoginAdminController::class, 'login'])
			->middleware('throttle:10,1')
			->name('admin.login');
	});

	Route::middleware([RedirectIfNotAuthenticated::class])->group(callback: function () {
		Route::prefix('super-admin')->group(function () {
			Route::middleware([IsSuperAdmin::class])->group(callback: function () {
				/**
				 * Akun Admin
				 */
				Route::prefix('akun-admin')->group(function () {
					Route::get('/', [AkunAdminSuperAdminController::class, 'index'])
						->name('admin.super.akun-admin.index');
					Route::get('/create', [AkunAdminSuperAdminController::class, 'create'])
						->name('admin.super.akun-admin.create');
					Route::post('/store', [AkunAdminSuperAdminController::class, 'store'])
						->name('admin.super.akun-admin.store');
					Route::get('/edit/{id}', [AkunAdminSuperAdminController::class, 'edit'])
						->name('admin.super.akun-admin.edit');
					Route::put('/update/{id}', [AkunAdminSuperAdminController::class, 'update'])
						->name('admin.super.akun-admin.update');
					Route::delete('/delete/{id}', [AkunAdminSuperAdminController::class, 'destroy'])
						->name('admin.super.akun-admin.destroy');
				});

				/**
				 * Log (TBA)
				 */
			});
		});

		/**
		 * Dashboard
		 */
		Route::get('/dashboard', [DashboardAdminController::class, 'index'])
			->name('admin.dashboard.index');

		/**
		 * Slider
		 */
		Route::prefix('slider')->group(function () {
			Route::get('/', [SliderAdminController::class, 'index'])
				->name('admin.slider.index');
			Route::post('/{id}/move-up', [SliderAdminController::class, 'moveUp'])
				->name('admin.slider.moveUp');
			Route::post('/{id}/move-down', [SliderAdminController::class, 'moveDown'])
				->name('admin.slider.moveDown');
			Route::get('/tambah', [SliderAdminController::class, 'create'])
				->name('admin.slider.create');
			Route::post('/store', [SliderAdminController::class, 'store'])
				->name('admin.slider.store');
			Route::delete('/delete/{id}', [SliderAdminController::class, 'destroy'])
				->name('admin.slider.destroy');
			Route::get('/edit/{id}', [SliderAdminController::class, 'edit'])
				->name('admin.slider.edit');
			Route::post('/update/{id}', [SliderAdminController::class, 'update'])
				->name('admin.slider.update');
		});

		/**
		 * Partner
		 */
		Route::prefix('partner')->group(function () {
			Route::get('/', [PartnerAdminController::class, 'index'])
				->name('admin.partner.index');
			Route::get('/tambah', [PartnerAdminController::class, 'create'])
				->name('admin.partner.create');
			Route::post('/store', [PartnerAdminController::class, 'store'])
				->name('admin.partner.store');
			Route::get('/edit/{id}', [PartnerAdminController::class, 'edit'])
				->name('admin.partner.edit');
			Route::post('/update/{id}', [PartnerAdminController::class, 'update'])
				->name('admin.partner.update');
			Route::delete('/delete/{id}', [PartnerAdminController::class, 'destroy'])
				->name('admin.partner.destroy');
		});

		/**
		 * Berita
		 */
		Route::prefix('berita')->group(function () {
			Route::prefix('kategori')->group(function () {
				Route::get('/', [BeritaKategoriAdminController::class, 'index'])
					->name('admin.berita.kategori.index');

				Route::get('/edit/{id}', [BeritaKategoriAdminController::class, 'edit'])
					->name('admin.berita.kategori.edit');

				Route::post('/update/{id}', [BeritaKategoriAdminController::class, 'update'])
					->name('admin.berita.kategori.update');
			});
			Route::get('/', [BeritaAdminController::class, 'index'])
				->name('admin.berita.index');
			Route::get('/create', [BeritaAdminController::class, 'create'])
				->name('admin.berita.create');
			Route::post('/store', [BeritaAdminController::class, 'store'])
				->name('admin.berita.store');
			Route::get('/edit/{id}', [BeritaAdminController::class, 'edit'])
				->name('admin.berita.edit');
			Route::post('/update/{id}', [BeritaAdminController::class, 'update'])
				->name('admin.berita.update');
			Route::delete('/delete/{id}', [BeritaAdminController::class, 'destroy'])
				->name('admin.berita.destroy');
		});

		/**
		 * PPID Pelaksana
		 */
		Route::prefix('ppid-pelaksana')->group(function () {
			Route::prefix('kategori')->group(function () {
				Route::get('/', [PPIDPelaksanaKategoriAdminController::class, 'index'])
					->name('admin.ppid-pelaksana.kategori.index');
				Route::get('/create', [PPIDPelaksanaKategoriAdminController::class, 'create'])
					->name('admin.ppid-pelaksana.kategori.create');
				Route::post('/store', [PPIDPelaksanaKategoriAdminController::class, 'store'])
					->name('admin.ppid-pelaksana.kategori.store');
				Route::delete('/delete/{id}', [PPIDPelaksanaKategoriAdminController::class, 'destroy'])
					->name('admin.ppid-pelaksana.kategori.destroy');
				Route::get('/edit/{id}', [PPIDPelaksanaKategoriAdminController::class, 'edit'])
					->name('admin.ppid-pelaksana.kategori.edit');
				Route::post('/update/{id}', [PPIDPelaksanaKategoriAdminController::class, 'update'])
					->name('admin.ppid-pelaksana.kategori.update');
			});
			Route::get('/', [PPIDPelaksanaAdminController::class, 'index'])
				->name('admin.ppid-pelaksana.index');
			Route::get('/create', [PPIDPelaksanaAdminController::class, 'create'])
				->name('admin.ppid-pelaksana.create');
			Route::post('/store', [PPIDPelaksanaAdminController::class, 'store'])
				->name('admin.ppid-pelaksana.store');
			Route::get('/edit/{id}', [PPIDPelaksanaAdminController::class, 'edit'])
				->name('admin.ppid-pelaksana.edit');
			Route::post('/update/{id}', [PPIDPelaksanaAdminController::class, 'update'])
				->name('admin.ppid-pelaksana.update');
			Route::delete('/delete/{id}', [PPIDPelaksanaAdminController::class, 'destroy'])
				->name('admin.ppid-pelaksana.destroy');
		});

		/**
		 * Pengumuman
		 */
		Route::prefix('pengumuman')->group(function () {
			Route::get('/', [PengumumanAdminController::class, 'index'])
				->name('admin.pengumuman.index');
			Route::get('/create', [PengumumanAdminController::class, 'create'])
				->name('admin.pengumuman.create');
			Route::post('/store', [PengumumanAdminController::class, 'store'])
				->name('admin.pengumuman.store');
			Route::get('/edit/{id}', [PengumumanAdminController::class, 'edit'])
				->name('admin.pengumuman.edit');
			Route::post('/update/{id}', [PengumumanAdminController::class, 'update'])
				->name('admin.pengumuman.update');
			Route::delete('/delete/{id}', [PengumumanAdminController::class, 'destroy'])
				->name('admin.pengumuman.destroy');
		});

		Route::prefix('struktur-organisasi')->group(function () {
			/**
			 * Struktur Organisasi
			 */
			Route::get('/', [StrukturOrganisasiAdminController::class, 'index'])
				->name('admin.struktur-organisasi.index');

			/**
			 * Organigram
			 */
			Route::prefix('organigram')->group(function () {
				Route::get('/edit/{id}', [OrganigramAdminController::class, 'edit'])
					->name('admin.struktur-organisasi.organigram.edit');
				Route::put('/update/{id}', [OrganigramAdminController::class, 'update'])
					->name('admin.struktur-organisasi.organigram.update');
			});

			/**
			 * Susunan Organisasi
			 */
			Route::prefix('susunan-organisasi')->group(function () {
				Route::get('/create', [SusunanOrganisasiAdminController::class, 'create'])
					->name('admin.struktur-organisasi.susunan-organisasi.create');
				Route::post('/store', [SusunanOrganisasiAdminController::class, 'store'])
					->name('admin.struktur-organisasi.susunan-organisasi.store');
				Route::get('/edit/{id}', [SusunanOrganisasiAdminController::class, 'edit'])
					->name('admin.struktur-organisasi.susunan-organisasi.edit');
				Route::put('/update/{id}', [SusunanOrganisasiAdminController::class, 'update'])
					->name('admin.struktur-organisasi.susunan-organisasi.update');
				Route::delete('/delete/{id}', [SusunanOrganisasiAdminController::class, 'destroy'])
					->name('admin.struktur-organisasi.susunan-organisasi.destroy');
			});
		});

		/**
		 * Kepala Dinas
		 */
		Route::prefix('kepala-dinas')->group(function () {
			Route::get('/', [KepalaDinasAdminController::class, 'index'])
				->name('admin.kepala-dinas.index');
			Route::get('/edit', [KepalaDinasAdminController::class, 'edit'])
				->name('admin.kepala-dinas.edit');
			Route::post('/update', [KepalaDinasAdminController::class, 'update'])
				->name('admin.kepala-dinas.update');
		});

		Route::prefix('profil')->group(function () {
			/**
			 * Visi dan Misi
			 */
			Route::prefix('visi-dan-misi')->group(function () {
				Route::get('/', [VisiDanMisiAdminController::class, 'index'])
					->name('admin.profil.visi-dan-misi.index');
				Route::get('/edit', [VisiDanMisiAdminController::class, 'edit'])
					->name('admin.profil.visi-dan-misi.edit');
				Route::post('/update', [VisiDanMisiAdminController::class, 'update'])
					->name('admin.profil.visi-dan-misi.update');
			});

			/**
			 * Sejarah Dinas PUPR Kota Samarinda
			 */
			Route::prefix('sejarah-dinas-pupr-kota-samarinda')->group(function () {
				Route::get('/', [SejarahDinasPUPRKotaSamarindaAdminController::class, 'index'])
					->name('admin.profil.sejarah-dinas-pupr-kota-samarinda.index');
				Route::get('/edit', [SejarahDinasPUPRKotaSamarindaAdminController::class, 'edit'])
					->name('admin.profil.sejarah-dinas-pupr-kota-samarinda.edit');
				Route::post('/update', [SejarahDinasPUPRKotaSamarindaAdminController::class, 'update'])
					->name('admin.profil.sejarah-dinas-pupr-kota-samarinda.update');
			});
		});
	});

	/**
	 * Logout
	 */
	Route::post('/logout', [LoginAdminController::class, 'logout'])
		->name('admin.logout');
});
