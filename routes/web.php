<?php

/*
|--------------------------------------------------------------------------
| Additional Route
|--------------------------------------------------------------------------
|
| Rute-rute berikut	digunakan untuk keperluan tambahan yang digunakan pada 
| Halaman Admin (E-Panel) dan Halaman Guest
|
*/

use App\Http\Controllers\Guest\DrainaseIrigasiGuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BlockSearchEngines;

/*
|--------------------------------------------------------------------------
| Halaman Guest
|--------------------------------------------------------------------------
|
| Rute-rute berikut dikhususkan untuk pengunjung umum yang mengakses
| website ini
|
*/

use App\Http\Controllers\Guest\PortalGuestController;
use App\Http\Controllers\Guest\BerandaGuestController;
use App\Http\Controllers\Guest\ProfilKepalaDinasGuestController;
use App\Http\Controllers\Guest\SejarahDinasPUPRKotaSamarindaGuestController;
use App\Http\Controllers\Guest\StrukturOrganisasiGuestController;
use App\Http\Controllers\Guest\VisiDanMisiGuestController;
use App\Http\Controllers\Guest\BeritaGuestController;
use App\Http\Controllers\Guest\BeritaKategoriGuestController;
use App\Http\Controllers\Guest\PengumumanGuestController;
use App\Http\Controllers\Guest\BukuTamuGuestController;
use App\Http\Controllers\Guest\PPIDPelaksanaKategoriGuestController;
use App\Http\Controllers\Guest\PPIDPelaksanaGuestController;
use App\Http\Controllers\Guest\SKMGuestController;
use App\Http\Controllers\Guest\AlbumKegiatanGuestController;
use App\Http\Controllers\Guest\AgendaKegiatanGuestController;
use App\Http\Controllers\Guest\KebijakanPrivasiGuestController;
use App\Http\Controllers\Guest\SedotTinjaGuestController;
use App\Http\Controllers\Guest\JalanPeduliLaporanGuestController;
use App\Http\Controllers\Guest\JalanPeduliFaqGuestController;
use App\Http\Controllers\Guest\JalanPeduliStatistikLaporanGuestController;

use App\Http\Middleware\RecordStatistikPengunjung;
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

Route::prefix('profil')->group(callback: function () {
	Route::get('/profil-kepala-dinas', [ProfilKepalaDinasGuestController::class, 'index'])
		->name('guest.profil.profil-kepala-dinas.index');

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

Route::prefix('pengumuman')->group(function () {
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

Route::prefix('ppid-pelaksana')->group(function () {
	Route::get('/kategori', [PPIDPelaksanaKategoriGuestController::class, 'index'])
		->name('guest.ppid-pelaksana.kategori.index');
	Route::get('/kategori/{slug}', [PPIDPelaksanaKategoriGuestController::class, 'show'])
		->name('guest.ppid-pelaksana.kategori.show');
	// Tambahkan route download
	Route::get('/download/{id}', [PPIDPelaksanaGuestController::class, 'download'])
		->name('guest.ppid-pelaksana.download');
});

/**
 * Album Kegiatan
 */

Route::prefix('album-kegiatan')->group(function () {
	Route::get('/', [AlbumKegiatanGuestController::class, 'index'])
		->name('guest.album-kegiatan.index');
	Route::get('/{slug}', [AlbumKegiatanGuestController::class, 'show'])
		->name('guest.album-kegiatan.show');
});

/**
 * Agenda Kegiatan
 */

Route::get('/agenda-kegiatan', function () {
	abort(503, 'Halaman ini sedang dalam pembaharuan');
})->name('guest.agenda-kegiatan.index');

Route::prefix('agenda-kegiatan')->middleware([BlockSearchEngines::class])->group(function () {
	Route::get('/ajax', [AgendaKegiatanGuestController::class, 'ajaxAgenda'])
		->name('guest.agenda-kegiatan.ajax');
	Route::get('/ajax-count', [AgendaKegiatanGuestController::class, 'ajaxAgendaCount'])
		->name('guest.agenda-kegiatan.ajax-count');
	Route::get('/ajax-week-count', [AgendaKegiatanGuestController::class, 'ajaxAgendaWeekCount'])
		->name('guest.agenda-kegiatan.ajax-week-count');
});

/**
 * SKM
 */

Route::prefix('skm')->middleware([BlockSearchEngines::class])->group(function () {
	Route::get('/', [SKMGuestController::class, 'index'])
		->name('guest.skm.index');
	Route::post('/', [SKMGuestController::class, 'store'])
		->name('guest.skm.store');
});

/**
 * Kebijakan Privasi
 */
Route::get('/kebijakan-privasi', [KebijakanPrivasiGuestController::class, 'index'])
	->name('guest.kebijakan-privasi.index');

/**
 * Buku Tamu
 */

// Route::prefix('buku-tamu')->middleware([BlockSearchEngines::class])->group(function () {
// 	Route::get('/', [BukuTamuGuestController::class, 'index'])
// 		->name('guest.buku-tamu.index');

// 	Route::get('/daftar', [BukuTamuGuestController::class, 'create'])
// 		->name('guest.buku-tamu.create');

// 	Route::post('/daftar', [BukuTamuGuestController::class, 'store'])
// 		->name('guest.buku-tamu.store');

// 	Route::get('/hasil', [BukuTamuGuestController::class, 'result'])
// 		->name('guest.buku-tamu.result');

// 	Route::get('/status', [BukuTamuGuestController::class, 'show'])
// 		->name('guest.buku-tamu.show');
// });

/**
 * Drainase Irigasi
 */
Route::prefix('drainase-irigasi')->group(function () {
	Route::get('/', [DrainaseIrigasiGuestController::class, 'index'])
		->name('guest.drainase-irigasi.index');

	Route::get('/lihat-laporan', [DrainaseIrigasiGuestController::class, 'show'])
		->name('guest.drainase-irigasi.show');
});

// 	Route::get('/buat-laporan', [DrainaseIrigasiGuestController::class, 'create'])
// 		->name('guest.drainase-irigasi.create');

// 	Route::post('/kirim-laporan', [DrainaseIrigasiGuestController::class, 'store'])
// 		->name('guest.drainase-irigasi.store');

// 	Route::get('/lihat-laporan', [DrainaseIrigasiGuestController::class, 'show'])
// 		->name('guest.drainase-irigasis.how');
// });

/**
 * Jalan Peduli Utama
 */

Route::prefix('jalan-peduli')->group(function () {
	Route::get('/', function () {
		return view('guest.pages.jalan-peduli.index', [
			'meta_description' => 'Website Jalan Peduli - Layanan pelaporan kerusakan jalan dan informasi tindak lanjut laporan di Kota Samarinda.',
			'page_title' => 'Jalan Peduli'
		]);
	})->name('guest.jalan-peduli.index');

	Route::get('/buat-laporan', [JalanPeduliLaporanGuestController::class, 'create'])
		->name('guest.jalan-peduli.laporan.create');

	Route::post('/buat-laporan', [JalanPeduliLaporanGuestController::class, 'store'])
		->name('guest.jalan-peduli.laporan.store');

	Route::get('/laporan/map', function () {
		return view('guest.pages.jalan-peduli.laporan.peta-sebaran',[
			'meta_description' => 'Buat Laporan Jalan Peduli - Layanan pelaporan kerusakan jalan di Kota Samarinda.',
			'page_title' => 'Buat Laporan Jalan Peduli'
		]);
	})->name('laporan.public.map');

	Route::get('/get-public-map-data', [JalanPeduliLaporanGuestController::class, 'getPublicMapCoordinates'])->name('laporan.public.map.coordinates');

	Route::get('/laporan/download/{id_laporan}', [JalanPeduliLaporanGuestController::class, 'downloadInvoice'])->name('laporan.download');
	
	Route::get('/laporan/data', [JalanPeduliLaporanGuestController::class, 'index'])->name('laporan.data');

	Route::get('/laporan/faq', [JalanPeduliFaqGuestController::class, 'index'])->name('faq');

	Route::get('/statistik', [JalanPeduliStatistikLaporanGuestController::class, 'index'])->name('guest.jalan-peduli.statistik-laporan');
});

/**
 * API Routes untuk Jalan Peduli
 */
Route::prefix('api')->group(function () {
	Route::get('/kelurahans/by-kecamatan/{kecamatan_id}', [JalanPeduliLaporanGuestController::class, 'getKelurahans'])
		->name('api.kelurahans.by-kecamatan');
});

/**
 * Sedot Tinja
 */
Route::prefix('sedot-tinja')->group(function () {
	Route::get('/', [SedotTinjaGuestController::class, 'index'])
		->name('guest.sedot-tinja.index');

	Route::get('/buat-laporan', [SedotTinjaGuestController::class, 'create'])
		->name('guest.sedot-tinja.create');

	Route::post('/kirim-laporan', [SedotTinjaGuestController::class, 'store'])
		->name('guest.sedot-tinja.store');

	Route::get('/lihat-laporan', [SedotTinjaGuestController::class, 'show'])
		->name('guest.sedot-tinja.show');

	Route::get('/success', [SedotTinjaGuestController::class, 'success'])
		->name('guest.sedot-tinja.success');

    Route::get('/status', [SedotTinjaGuestController::class, 'status'])
		->name('guest.sedot-tinja.status');
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

use App\Http\Controllers\Admin\LoginAdminController;  
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\SliderAdminController;
use App\Http\Controllers\Admin\PartnerAdminController;
use App\Http\Controllers\Admin\BeritaKategoriAdminController;
use App\Http\Controllers\Admin\BeritaAdminController;
use App\Http\Controllers\Admin\PPIDPelaksanaKategoriAdminController;
use App\Http\Controllers\Admin\PengumumanAdminController;
use App\Http\Controllers\Admin\PPIDPelaksanaAdminController;
use App\Http\Controllers\Admin\SusunanOrganisasiAdminController;
use App\Http\Controllers\Admin\KepalaDinasAdminController;
use App\Http\Controllers\Admin\VisiDanMisiAdminController;
use App\Http\Controllers\Admin\SejarahDinasPUPRKotaSamarindaAdminController;
use App\Http\Controllers\Admin\StrukturOrganisasiAdminController;
use App\Http\Controllers\Admin\OrganigramAdminController;
use App\Http\Controllers\Admin\BukuTamuAdminController;
use App\Http\Controllers\Admin\FotoKegiatanAdminController;
use App\Http\Controllers\Admin\AlbumKegiatanAdminController;
use App\Http\Controllers\Admin\AgendaKegiatanAdminController;
use App\Http\Controllers\Admin\KelolaAkunSayaAdminController;
use App\Http\Controllers\Admin\SedotTinjaAdminController;
use App\Http\Controllers\Admin\JalanPeduliLaporanMasukAdminController;
use App\Http\Controllers\Admin\JalanPeduliTindaklanjutiLaporanAdminController;
use App\Http\Controllers\Admin\APIKeySuperAdminController;

use App\Http\Controllers\Admin\AkunAdminSuperAdminController;

Route::prefix('e-panel')->middleware([BlockSearchEngines::class])->group(function () {
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
				 * API Key
				 */
				Route::prefix('api-key')->group(function () {
					Route::get('/', [APIKeySuperAdminController::class, 'index'])
						->name('admin.super.api-key.index');
					Route::get('/create', [APIKeySuperAdminController::class, 'create'])
						->name('admin.super.api-key.create');
					Route::post('/store', [APIKeySuperAdminController::class, 'store'])
						->name('admin.super.api-key.store');
					Route::put('/update/{id}', [APIKeySuperAdminController::class, 'update'])
						->name('admin.super.api-key.update');
					Route::delete('/delete/{id}', [APIKeySuperAdminController::class, 'destroy'])
						->name('admin.super.api-key.destroy');
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
		 * Jalan Peduli
		 */
		Route::prefix('jalan-peduli')->group(function () {
			Route::prefix('laporan-masuk')->group(function () {
				Route::get('', [JalanPeduliLaporanMasukAdminController::class, 'index'])
					->name('admin.jalan-peduli.laporan-masuk.index');
				Route::get('/lihat/{id}', [JalanPeduliLaporanMasukAdminController::class, 'show'])
					->name('admin.jalan-peduli.laporan-masuk.show');
				Route::post('/update/{id}', [JalanPeduliLaporanMasukAdminController::class, 'update'])
					->name('admin.jalan-peduli.laporan-masuk.update');
				Route::post('/delete/{id}', [JalanPeduliLaporanMasukAdminController::class, 'destroy'])
					->name('admin.jalan-peduli.laporan-masuk.destroy');
			});

			Route::prefix('statistik-laporan')->group(function () {
				Route::get('/', [JalanPeduliStatistikLaporanGuestController::class, 'index'])
					->name('admin.jalan-peduli.statistik-laporan.index');
			});

			Route::prefix('tindaklanjuti-laporan')->group(function () {
				Route::get('/', [JalanPeduliTindaklanjutiLaporanAdminController::class, 'index'])
					->name('admin.jalan-peduli.tindaklanjuti-laporan.index');
				Route::get('/edit/{id}', [JalanPeduliTindaklanjutiLaporanAdminController::class, 'edit'])
					->name('admin.jalan-peduli.tindaklanjuti-laporan.edit');
				Route::post('/update/{id}', [JalanPeduliTindaklanjutiLaporanAdminController::class, 'update'])
					->name('admin.jalan-peduli.tindaklanjuti-laporan.update');
				Route::delete('/delete/{id}', [JalanPeduliTindaklanjutiLaporanAdminController::class, 'destroy'])
					->name('admin.jalan-peduli.tindaklanjuti-laporan.destroy');
				// UPDATED: Route for downloading individual report (now a ZIP with CSV and photos)
				Route::get('/laporan/{id_laporan}/download', [JalanPeduliLaporanMasukAdminController::class, 'download'])->name('admin.laporan.download');
				// UPDATED: Route for downloading ALL filtered reports (now a ZIP with PDF summary and photos)
				Route::get('/laporan/download-all', [JalanPeduliLaporanMasukAdminController::class, 'downloadAll'])->name('admin.laporan.downloadAll');
			});
		});

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
		 * Kelola Akun Saya
		 */
		Route::prefix('kelola-akun-saya')->group(function () {
			Route::get('/edit/{id}', [KelolaAkunSayaAdminController::class, 'edit'])
				->name('admin.kelola-akun-saya.edit');
			Route::put('/update/{id}', [KelolaAkunSayaAdminController::class, 'update'])
				->name('admin.kelola-akun-saya.update');
			Route::delete('/delete/{id}', [KelolaAkunSayaAdminController::class, 'destroy'])
				->name('admin.kelola-akun-saya.destroy');
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
			Route::post('/upload-quill-image', [BeritaAdminController::class, 'uploadQuillImage'])
				->name('admin.berita.uploadQuillImage');
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

		/**
		 * Agenda Kegiatan
		 */
		Route::prefix('agenda-kegiatan')->group(function () {
			Route::get('/', [AgendaKegiatanAdminController::class, 'index'])
				->name('admin.agenda-kegiatan.index');
			Route::get('/create', [AgendaKegiatanAdminController::class, 'create'])
				->name('admin.agenda-kegiatan.create');
			Route::post('/store', [AgendaKegiatanAdminController::class, 'store'])
				->name('admin.agenda-kegiatan.store');
			Route::get('/edit/{id}', [AgendaKegiatanAdminController::class, 'edit'])
				->name('admin.agenda-kegiatan.edit');
			Route::post('/update/{id}', [AgendaKegiatanAdminController::class, 'update'])
				->name('admin.agenda-kegiatan.update');
			Route::delete('/delete/{id}', [AgendaKegiatanAdminController::class, 'destroy'])
				->name('admin.agenda-kegiatan.destroy');
			Route::get('/datatable', [AgendaKegiatanAdminController::class, 'datatable'])
				->name('admin.agenda-kegiatan.datatable');
		});

		/**
		 * Buku Tamu
		 */
		Route::prefix('buku-tamu')->group(function () {
			Route::get('/', [BukuTamuAdminController::class, 'index'])
				->name('admin.buku-tamu.index');
			Route::get('/edit/{id}', [BukuTamuAdminController::class, 'edit'])
				->name('admin.buku-tamu.edit');
			Route::post('/update/{id}', [BukuTamuAdminController::class, 'update'])
				->name('admin.buku-tamu.update');
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

		/*
		 * Album Kegiatan
		 */
		Route::prefix('album-kegiatan')->group(function () {
			Route::get('/', [AlbumKegiatanAdminController::class, 'index'])
				->name('admin.album-kegiatan.index');
			Route::get('/create', [AlbumKegiatanAdminController::class, 'create'])
				->name('admin.album-kegiatan.create');
			Route::post('/store', [AlbumKegiatanAdminController::class, 'store'])
				->name('admin.album-kegiatan.store');
			Route::get('/edit/{id}', [AlbumKegiatanAdminController::class, 'edit'])
				->name('admin.album-kegiatan.edit');
			Route::post('/update/{id}', [AlbumKegiatanAdminController::class, 'update'])
				->name('admin.album-kegiatan.update');
			Route::delete('/delete/{id}', [AlbumKegiatanAdminController::class, 'destroy'])
				->name('admin.album-kegiatan.destroy');
			Route::get('/{id}', [AlbumKegiatanAdminController::class, 'show'])
				->name('admin.album-kegiatan.show');

			/**
			 * Foto Kegiatan
			 */
			Route::prefix('foto-kegiatan')->group(function () {
				Route::get('/create/{album}', [FotoKegiatanAdminController::class, 'create'])
					->name('admin.album-kegiatan.foto-kegiatan.create');
				Route::post('/store/{album}', [FotoKegiatanAdminController::class, 'store'])
					->name('admin.album-kegiatan.foto-kegiatan.store');
				Route::get('/edit/{album}/{foto}', [FotoKegiatanAdminController::class, 'edit'])
					->name('admin.album-kegiatan.foto-kegiatan.edit');
				Route::put('/update/{album}/{foto}', [FotoKegiatanAdminController::class, 'update'])
					->name('admin.album-kegiatan.foto-kegiatan.update');
				Route::delete('/delete/{album}/{foto}', [FotoKegiatanAdminController::class, 'destroy'])
					->name('admin.album-kegiatan.foto-kegiatan.destroy');
			});
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

		/**
		 * Sedot Tinja
		 */
		Route::prefix('sedot-tinja')->group(function () {
			Route::get('/', [SedotTinjaAdminController::class, 'index'])
				->name('admin.sedot-tinja.index');

			Route::get('/kelola-laporan', [SedotTinjaAdminController::class, 'edit'])
				->name('admin.sedot-tinja.create');

			Route::post('/perbarui-laporan', [SedotTinjaAdminController::class, 'update'])
				->name('admin.sedot-tinja.store');

			Route::get('/lihat-laporan', [SedotTinjaAdminController::class, 'show'])
				->name('admin.sedot-tinja.show');
		});
	});

	/**
	 * Logout
	 */
	Route::post('/logout', [LoginAdminController::class, 'logout'])
		->name('admin.logout');
});

