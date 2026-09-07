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


use App\Http\Controllers\Guest\HantuBanyuGuestController;
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
use App\Http\Controllers\Guest\SitemapGuestController;
use App\Http\Controllers\Guest\BerandaGuestController;
use App\Http\Controllers\Guest\ProfilKepalaDinasGuestController;
use App\Http\Controllers\Guest\SejarahDinasPUPRKotaSamarindaGuestController;
use App\Http\Controllers\Guest\StrukturOrganisasiGuestController;
use App\Http\Controllers\Guest\VisiDanMisiGuestController;
use App\Http\Controllers\Guest\BeritaGuestController;
use App\Http\Controllers\Guest\BeritaKategoriGuestController;
use App\Http\Controllers\Guest\PengumumanGuestController;
use App\Http\Controllers\Guest\PPIDPelaksanaKategoriGuestController;
use App\Http\Controllers\Guest\PPIDPelaksanaGuestController;
use App\Http\Controllers\Guest\SKMGuestController;
use App\Http\Controllers\Guest\AlbumKegiatanGuestController;
use App\Http\Controllers\Guest\AgendaKegiatanGuestController;
use App\Http\Controllers\Guest\KebijakanPrivasiGuestController;
use App\Http\Controllers\Guest\JalanPeduliLaporanGuestController;
use App\Http\Controllers\Guest\SilaladGuestController;
use App\Http\Controllers\Guest\HantuBanyuPengaduanGuestController;
use App\Http\Controllers\Guest\HantuBanyuPetaSebaranGuestController;
use App\Http\Controllers\Guest\LoginKelurahanGuestController;
use App\Http\Controllers\Guest\AkunKelurahanGuestController;

use App\Http\Middleware\RecordStatistikPengunjung;

/**
 * Portal
 */

Route::get('/', [PortalGuestController::class, 'index'])
  ->name('guest.portal.index');

/**
 * Peta situs untuk mesin pencari (dirakit dari database, bukan berkas statis).
 */
Route::get('/sitemap.xml', [SitemapGuestController::class, 'index'])
  ->name('guest.sitemap');
Route::get('/robots.txt', [SitemapGuestController::class, 'robots'])
  ->name('guest.robots');

/**
 * Beranda
 */

Route::get('/beranda', [BerandaGuestController::class, 'index'])
  ->name('guest.beranda.index');

/**
 * Profil
 */
use App\Http\Controllers\Guest\TupoksiGuestController;

Route::prefix('profil')->group(callback: function () {
  Route::get('/profil-kepala-dinas', [ProfilKepalaDinasGuestController::class, 'index'])
    ->name('guest.profil.profil-kepala-dinas.index');

  Route::get('/sejarah-dinas-pupr-kota-samarinda', [SejarahDinasPUPRKotaSamarindaGuestController::class, 'index'])
    ->name('guest.profil.sejarah-dinas-pupr-kota-samarinda.index');

  Route::get('/visi-dan-misi', [VisiDanMisiGuestController::class, 'index'])
    ->name('guest.profil.visi-dan-misi.index');

  Route::get('/tupoksi', [TupoksiGuestController::class, 'index'])
    ->name('guest.profil.tupoksi.index');

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
 * Jalan Peduli Utama
 */
use App\Http\Controllers\Guest\JalanPeduliFaqGuestController;
use App\Http\Controllers\Guest\JalanPeduliStatistikLaporanGuestController;

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
  Route::get('/laporan/download-public/{id_laporan}', [JalanPeduliLaporanGuestController::class, 'downloadInvoicePublic'])->name('laporan.download.public');
  
  Route::get('/laporan/data', [JalanPeduliLaporanGuestController::class, 'index'])->name('laporan.data');

  Route::get('/laporan/faq', [JalanPeduliFaqGuestController::class, 'index'])->name('faq');

  Route::get('/statistik', [JalanPeduliStatistikLaporanGuestController::class, 'index'])->name('guest.jalan-peduli.statistik-laporan');
});

/**
 * SILALAD (Sistem Informasi Layanan Limbah Domestik)
 */
Route::prefix('silalad')->group(function () {
  Route::get('/', [SilaladGuestController::class, 'index'])
    ->name('guest.silalad.index');
  Route::get('/buat-laporan', [SilaladGuestController::class, 'create'])
    ->name('guest.silalad.create');
  Route::post('/kirim-laporan', [SilaladGuestController::class, 'store'])
    ->name('guest.silalad.store');
  Route::get('/status', [SilaladGuestController::class, 'status'])
    ->name('guest.silalad.status');
  Route::get('/success', [SilaladGuestController::class, 'success'])
    ->name('guest.silalad.success');
  Route::get('/{id}', [SilaladGuestController::class, 'show'])
    ->whereNumber('id')
    ->name('guest.silalad.show');
});

/**
 * Hantu Banyu (Pemeliharaan Saluran Drainase dan Irigasi)
 *
 * Redirect permanen dari URL lama /drainase-irigasi/* agar tautan yang
 * terlanjur tersebar tidak mati setelah penggantian nama fitur.
 */
Route::get('drainase-irigasi/{sisa?}', function (?string $sisa = null) {
  return redirect('/hantu-banyu' . ($sisa ? '/' . $sisa : ''), 301);
})->where('sisa', '.*');

Route::prefix('hantu-banyu')->group(function () {
  /**
   * Login Akun Kelurahan
   *
   * Seluruh fitur Drainase dan Irigasi (termasuk halaman beranda) hanya
   * dapat diakses setelah login menggunakan akun kelurahan.
   */
  Route::middleware(['guest.kelurahan'])->group(function () {
    Route::get('/login', [LoginKelurahanGuestController::class, 'index'])
      ->name('guest.hantu-banyu.login.index');
    Route::post('/login', [LoginKelurahanGuestController::class, 'login'])
      ->middleware('throttle:10,1')
      ->name('guest.hantu-banyu.login');
  });

  Route::post('/logout', [LoginKelurahanGuestController::class, 'logout'])
    ->name('guest.hantu-banyu.logout');

  /**
   * Fitur Drainase dan Irigasi (wajib login akun kelurahan)
   */
  Route::middleware(['auth.kelurahan'])->group(function () {
    Route::get('/', [HantuBanyuGuestController::class, 'index'])
      ->name('guest.hantu-banyu.index');

    /**
     * Kelola Akun Kelurahan
     */
    Route::get('/akun', [AkunKelurahanGuestController::class, 'edit'])
      ->name('guest.hantu-banyu.akun.edit');
    Route::put('/akun', [AkunKelurahanGuestController::class, 'update'])
      ->name('guest.hantu-banyu.akun.update');

    Route::get('/pengaduan/buat', [HantuBanyuPengaduanGuestController::class, 'create'])
      ->name('guest.hantu-banyu.pengaduan.create');
    Route::post('/pengaduan/kirim', [HantuBanyuPengaduanGuestController::class, 'store'])
      ->name('guest.hantu-banyu.pengaduan.store');

    Route::get('/pengaduan/bukti-pengaduan/{id}', [HantuBanyuPengaduanGuestController::class, 'pdf'])
      ->middleware('validate.signed.access')
      ->name('guest.hantu-banyu.pengaduan.pdf');

    Route::get('/pengaduan/hasil/{id}', [HantuBanyuPengaduanGuestController::class, 'result'])
      ->middleware('validate.signed.access')
      ->name('guest.hantu-banyu.pengaduan.result');

    Route::get('/pengaduan/lihat', [HantuBanyuPengaduanGuestController::class, 'index'])
      ->name('guest.hantu-banyu.pengaduan.index');

    Route::get('/pengaduan/lihat/{id}', [HantuBanyuPengaduanGuestController::class, 'show'])
      ->name('guest.hantu-banyu.pengaduan.show');

    Route::get('/peta-sebaran', [HantuBanyuPetaSebaranGuestController::class, 'index'])
      ->name('guest.hantu-banyu.peta-sebaran.index');
  });
});

/**
 * API Routes untuk Jalan Peduli
 */
Route::prefix('api')->group(function () {
  Route::get('/kecamatans', [JalanPeduliLaporanGuestController::class, 'getKecamatans'])
    ->name('api.kecamatans');
  Route::get('/kelurahans/by-kecamatan/{kecamatan_id}', [JalanPeduliLaporanGuestController::class, 'getKelurahans'])
    ->name('api.kelurahans.by-kecamatan');
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
use App\Http\Controllers\Admin\OrganigramAdminController;
use App\Http\Controllers\Admin\FotoKegiatanAdminController;
use App\Http\Controllers\Admin\AlbumKegiatanAdminController;
use App\Http\Controllers\Admin\AgendaKegiatanAdminController;
use App\Http\Controllers\Admin\KelolaAkunSayaAdminController;
use App\Http\Controllers\Admin\JalanPeduliLaporanMasukAdminController;
use App\Http\Controllers\Admin\JalanPeduliTindaklanjutiLaporanAdminController;
use App\Http\Controllers\Admin\APIKeySuperAdminController;
use App\Http\Controllers\Admin\HantuBanyuAdminController;
use App\Http\Controllers\Admin\HantuBanyuLaporanAdminController;
use App\Http\Controllers\Admin\HantuBanyuStatistikLaporanAdminController;
use App\Http\Controllers\Admin\HantuBanyuSKMAdminController;
use App\Http\Controllers\Admin\SilaladAdminController;
use App\Http\Controllers\Admin\SilaladSKMAdminController;
use App\Http\Controllers\Admin\SilaladStatistikLaporanAdminController;

use App\Http\Controllers\Admin\AkunAdminSuperAdminController;
use App\Http\Controllers\Admin\AkunKelurahanSuperAdminController;
use App\Http\Controllers\Admin\LogSuperAdminController;

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
         * Akun Kelurahan
         *
         * Berada di level super admin karena akun kelurahan dipakai bersama
         * lintas fitur, bukan milik salah satu fitur saja.
         */
        Route::prefix('akun-kelurahan')->group(function () {
          Route::get('/', [AkunKelurahanSuperAdminController::class, 'index'])
            ->name('admin.super.akun-kelurahan.index');
          Route::get('/create', [AkunKelurahanSuperAdminController::class, 'create'])
            ->name('admin.super.akun-kelurahan.create');
          Route::post('/store', [AkunKelurahanSuperAdminController::class, 'store'])
            ->name('admin.super.akun-kelurahan.store');
          Route::get('/edit/{id}', [AkunKelurahanSuperAdminController::class, 'edit'])
            ->whereNumber('id')
            ->name('admin.super.akun-kelurahan.edit');
          Route::put('/update/{id}', [AkunKelurahanSuperAdminController::class, 'update'])
            ->whereNumber('id')
            ->name('admin.super.akun-kelurahan.update');
          Route::delete('/delete/{id}', [AkunKelurahanSuperAdminController::class, 'destroy'])
            ->whereNumber('id')
            ->name('admin.super.akun-kelurahan.destroy');
        });

        /**
         * API Key
         */
        Route::prefix('api-key')->group(function () {
          Route::prefix('jalan-peduli')->group(function () {
            Route::get('/', [APIKeySuperAdminController::class, 'indexJalanPeduli'])
              ->name('admin.super.api-key.jalan-peduli.index');
            Route::get('/create', [APIKeySuperAdminController::class, 'createJalanPeduli'])
              ->name('admin.super.api-key.jalan-peduli.create');
          });

          Route::prefix('hantu-banyu')->group(function () {
            Route::get('/', [APIKeySuperAdminController::class, 'indexHantuBanyu'])
              ->name('admin.super.api-key.hantu-banyu.index');
            Route::get('/create', [APIKeySuperAdminController::class, 'createHantuBanyu'])
              ->name('admin.super.api-key.hantu-banyu.create');
          });

          Route::prefix('silalad')->group(function () {
            Route::get('/', [APIKeySuperAdminController::class, 'indexSilalad'])
              ->name('admin.super.api-key.silalad.index');
            Route::get('/create', [APIKeySuperAdminController::class, 'createSilalad'])
              ->name('admin.super.api-key.silalad.create');
          });

          Route::prefix('akun-kelurahan')->group(function () {
            Route::get('/', [APIKeySuperAdminController::class, 'indexAkunKelurahan'])
              ->name('admin.super.api-key.akun-kelurahan.index');
            Route::get('/create', [APIKeySuperAdminController::class, 'createAkunKelurahan'])
              ->name('admin.super.api-key.akun-kelurahan.create');
          });
        });

        /**
         * Log Aktivitas
         */
        Route::prefix('log')->group(function () {
          Route::get('/', [LogSuperAdminController::class, 'index'])
            ->name('admin.super.log.index');
          Route::get('/lihat/{id}', [LogSuperAdminController::class, 'show'])
            ->name('admin.super.log.show');
        });
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
     * Hantu Banyu (Drainase & Irigasi)
     */
    Route::prefix('hantu-banyu')->group(function () {
      Route::get('/', [HantuBanyuAdminController::class, 'index'])
        ->name('admin.hantu-banyu.index');

      Route::prefix('laporan')->group(function () {
        Route::get('/', [HantuBanyuLaporanAdminController::class, 'index'])
          ->name('admin.hantu-banyu.laporan.index');
        Route::get('/unduh-pdf', [HantuBanyuLaporanAdminController::class, 'unduhPdf'])
          ->name('admin.hantu-banyu.laporan.unduh-pdf');
        Route::get('/{id}', [HantuBanyuLaporanAdminController::class, 'edit'])
          ->whereNumber('id')
          ->name('admin.hantu-banyu.laporan.edit');
        Route::get('/{id}/pdf', [HantuBanyuLaporanAdminController::class, 'unduhPdfSatu'])
          ->whereNumber('id')
          ->name('admin.hantu-banyu.laporan.pdf');

        Route::post('/{id}/slot/{status}', [HantuBanyuLaporanAdminController::class, 'simpanSlot'])
          ->whereNumber('id')->whereIn('status', HantuBanyuLaporanAdminController::STATUS)
          ->name('admin.hantu-banyu.laporan.slot.simpan');
      });

      Route::prefix('statistik-laporan')->group(function () {
        Route::get('/', [HantuBanyuStatistikLaporanAdminController::class, 'index'])
          ->name('admin.hantu-banyu.statistik-laporan.index');
      });

      Route::prefix('skm')->group(function () {
        Route::get('/', [HantuBanyuSKMAdminController::class, 'index'])
          ->name('admin.hantu-banyu.skm.index');
      });

    });

    /**
     * SILALAD
     */
    Route::prefix('silalad')->group(function () {
      Route::get('/data-pesanan', [SilaladAdminController::class, 'dataPesanan'])
        ->name('admin.silalad.data-pesanan');
      Route::get('/statistik-laporan', [SilaladStatistikLaporanAdminController::class, 'index'])
        ->name('admin.silalad.statistik-laporan.index');
      Route::get('/skm', [SilaladSKMAdminController::class, 'index'])
        ->name('admin.silalad.skm.index');
      Route::get('/{silalad}/edit', [SilaladAdminController::class, 'edit'])
        ->name('admin.silalad.edit');
      Route::post('/{silalad}/slot/{slug}', [SilaladAdminController::class, 'simpanSlot'])
        ->whereIn('slug', array_keys(SilaladAdminController::SLOT_SLUG))
        ->name('admin.silalad.slot.simpan');
      Route::put('/{silalad}', [SilaladAdminController::class, 'update'])
        ->name('admin.silalad.update');
      Route::delete('/{silalad}', [SilaladAdminController::class, 'destroy'])
        ->name('admin.silalad.destroy');
      Route::get('/{silalad}/print', [SilaladAdminController::class, 'print'])
        ->name('admin.silalad.print');
      Route::get('/{silalad}/surat-pesanan', [SilaladAdminController::class, 'printSuratPesanan'])
        ->name('admin.silalad.surat-pesanan');
      Route::get('/{silalad}/surat-perintah-kerja', [SilaladAdminController::class, 'printSuratPerintahKerja'])
        ->name('admin.silalad.surat-perintah-kerja');
      Route::get('/{silalad}/surat-jalan', [SilaladAdminController::class, 'printSuratJalan'])
        ->name('admin.silalad.surat-jalan');
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

    Route::prefix('struktur-organisasi')->group(function () {
      /**
       * Organigram
       */
      Route::prefix('organigram')->group(function () {
        Route::get('/', [OrganigramAdminController::class, 'index'])
          ->name('admin.struktur-organisasi.organigram.index');
        Route::get('/edit/{id}', [OrganigramAdminController::class, 'edit'])
          ->name('admin.struktur-organisasi.organigram.edit');
        Route::put('/update/{id}', [OrganigramAdminController::class, 'update'])
          ->name('admin.struktur-organisasi.organigram.update');
      });

      /**
       * Susunan Organisasi
       */
      Route::prefix('susunan-organisasi')->group(function () {
        Route::get('/', [SusunanOrganisasiAdminController::class, 'index'])
          ->name('admin.struktur-organisasi.susunan-organisasi.index');
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
  });

  /**
   * Logout
   */
  Route::post('/logout', [LoginAdminController::class, 'logout'])
    ->name('admin.logout');
});

