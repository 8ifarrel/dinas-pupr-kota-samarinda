<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\CaptchaController;

// Jalan Peduli
use App\Http\Controllers\Api\JalanPeduliApiKeyController;
use App\Http\Controllers\Guest\JalanPeduliApiLaporanUserGuest;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\TensorFlowModelController;
use App\Http\Controllers\Api\TensorFlowTestController;

// Hantu Banyu
use App\Http\Controllers\Api\HantuBanyuApiKeyController;
use App\Http\Controllers\Api\HantuBanyuLaporanController;
use App\Http\Controllers\Api\GeocodingController;

// Akun Kelurahan
use App\Http\Controllers\Api\KelurahanApiKeyController;
use App\Http\Controllers\Api\AkunKelurahanController;


//==================================================================//
//                              UMUM                                //
//==================================================================//

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');


//==================================================================//
//                          JALAN PEDULI                            //
//==================================================================//

//---------------API KEY MANAGEMENT--------------------//
// HANYA untuk super admin yang sudah login via web interface
Route::prefix('keys')->middleware(['web'])->group(function () {
  // Middleware khusus untuk memastikan user adalah super admin
  Route::middleware(\App\Http\Middleware\RedirectIfNotAuthenticated::class, \App\Http\Middleware\IsSuperAdmin::class)->group(function () {
    Route::get('/', [JalanPeduliApiKeyController::class, 'index'])->name('api.keys.index');
    Route::post('/', [JalanPeduliApiKeyController::class, 'store'])->name('api.keys.store');
    Route::get('/{id}', [JalanPeduliApiKeyController::class, 'show'])->name('api.keys.show');
    Route::put('/{id}', [JalanPeduliApiKeyController::class, 'update'])->name('api.keys.update');
    Route::delete('/{id}', [JalanPeduliApiKeyController::class, 'destroy'])->name('api.keys.destroy');
    Route::post('/{id}/regenerate', [JalanPeduliApiKeyController::class, 'regenerate'])->name('api.keys.regenerate');
    Route::get('/{id}/usage', [JalanPeduliApiKeyController::class, 'getUsageStats'])->name('api.keys.usage');
  });

  // Route validate bisa diakses oleh siapa saja (untuk testing API key)
  Route::post('/validate', [JalanPeduliApiKeyController::class, 'validate'])->name('api.keys.validate');
});

// ---------------LAPORAN API--------------------//
Route::get('/laporan', [JalanPeduliApiLaporanUserGuest::class, 'index'])->name('api.laporan.index');
Route::get('/laporan/{id_laporan}', [JalanPeduliApiLaporanUserGuest::class, 'show'])->name('api.laporan.show');

// Route POST untuk membuat laporan baru, DENGAN middleware API Key
Route::post('/laporan/upload', [JalanPeduliApiLaporanUserGuest::class, 'store'])
   ->name('api.laporan.store')
   ->middleware('auth.apikey');

//---------------GOOGLE MAP GET KORDINAT--------------------//
Route::get('/kordinat', [MapController::class, 'getCoordinates']);

//---------------MACHINE LEARNING MODEL API--------------------//
Route::get('/ml/model-info', [TensorFlowModelController::class, 'getModelInfo'])->name('api.ml.model-info');
Route::get('/ml/health', [TensorFlowModelController::class, 'checkModelHealth'])->name('api.ml.health');

//---------------SERVER TENSORFLOW.JS TESTING--------------------//
Route::get('/tensorflow/status', [TensorFlowTestController::class, 'testService'])->name('api.tensorflow.status');
Route::post('/tensorflow/predict', [TensorFlowTestController::class, 'testPrediction'])->name('api.tensorflow.predict');


//==================================================================//
//                           HANTU BANYU                            //
//==================================================================//

//---------------API KEY MANAGEMENT--------------------//
// HANYA untuk super admin yang sudah login via web interface
Route::prefix('hantu-banyu-keys')->middleware(['web'])->group(function () {
  // Middleware khusus untuk memastikan user adalah super admin
  Route::middleware(\App\Http\Middleware\RedirectIfNotAuthenticated::class, \App\Http\Middleware\IsSuperAdmin::class)->group(function () {
    Route::get('/', [HantuBanyuApiKeyController::class, 'index'])->name('api.hantu-banyu-keys.index');
    Route::post('/', [HantuBanyuApiKeyController::class, 'store'])->name('api.hantu-banyu-keys.store');
    Route::get('/{id}', [HantuBanyuApiKeyController::class, 'show'])->name('api.hantu-banyu-keys.show');
    Route::put('/{id}', [HantuBanyuApiKeyController::class, 'update'])->name('api.hantu-banyu-keys.update');
    Route::delete('/{id}', [HantuBanyuApiKeyController::class, 'destroy'])->name('api.hantu-banyu-keys.destroy');
    Route::post('/{id}/regenerate', [HantuBanyuApiKeyController::class, 'regenerate'])->name('api.hantu-banyu-keys.regenerate');
    Route::get('/{id}/usage', [HantuBanyuApiKeyController::class, 'getUsageStats'])->name('api.hantu-banyu-keys.usage');
  });

  // Route validate bisa diakses oleh siapa saja (untuk testing API key)
  Route::post('/validate', [HantuBanyuApiKeyController::class, 'validate'])->name('api.hantu-banyu-keys.validate');
});

// ---------------LAPORAN API--------------------//
// Keduanya memakai kunci API Hantu Banyu; kunci Jalan Peduli tidak berlaku di sini.
Route::prefix('hantu-banyu/laporan')->middleware('auth.apikey:hantu-banyu')->group(function () {
  Route::post('/upload', [HantuBanyuLaporanController::class, 'store'])
    ->name('api.hantu-banyu-laporan.store');
  Route::get('/{kode}', [HantuBanyuLaporanController::class, 'show'])
    ->name('api.hantu-banyu-laporan.show');
});

//---------------REVERSE GEOCODING--------------------//
Route::get('/hantu-banyu/reverse-geocode', [GeocodingController::class, 'reverseGeocode'])
  ->name('api.hantu-banyu.reverse-geocode');


//==================================================================//
//                         AKUN KELURAHAN                           //
//==================================================================//

//---------------API KEY MANAGEMENT--------------------//
// HANYA untuk super admin yang sudah login via web interface
Route::prefix('akun-kelurahan-keys')->middleware(['web'])->group(function () {
  // Middleware khusus untuk memastikan user adalah super admin
  Route::middleware(\App\Http\Middleware\RedirectIfNotAuthenticated::class, \App\Http\Middleware\IsSuperAdmin::class)->group(function () {
    Route::get('/', [KelurahanApiKeyController::class, 'index'])->name('api.akun-kelurahan-keys.index');
    Route::post('/', [KelurahanApiKeyController::class, 'store'])->name('api.akun-kelurahan-keys.store');
    Route::get('/{id}', [KelurahanApiKeyController::class, 'show'])->name('api.akun-kelurahan-keys.show');
    Route::put('/{id}', [KelurahanApiKeyController::class, 'update'])->name('api.akun-kelurahan-keys.update');
    Route::delete('/{id}', [KelurahanApiKeyController::class, 'destroy'])->name('api.akun-kelurahan-keys.destroy');
    Route::post('/{id}/regenerate', [KelurahanApiKeyController::class, 'regenerate'])->name('api.akun-kelurahan-keys.regenerate');
    Route::get('/{id}/usage', [KelurahanApiKeyController::class, 'getUsageStats'])->name('api.akun-kelurahan-keys.usage');
  });

  // Route validate bisa diakses oleh siapa saja (untuk testing API key)
  Route::post('/validate', [KelurahanApiKeyController::class, 'validate'])->name('api.akun-kelurahan-keys.validate');
});

// ---------------AKUN KELURAHAN API--------------------//
// Memakai kunci API akun kelurahan; kunci Jalan Peduli maupun Hantu Banyu
// tidak berlaku di sini, begitu pula sebaliknya.
Route::prefix('akun-kelurahan')->middleware('auth.apikey:akun-kelurahan')->group(function () {
  Route::get('/', [AkunKelurahanController::class, 'index'])
    ->name('api.akun-kelurahan.index');

  // Diberi throttle karena endpoint ini memeriksa kata sandi: tanpa batas
  // laju, kunci API yang bocor bisa dipakai menebak sandi tanpa henti.
  Route::post('/verifikasi', [AkunKelurahanController::class, 'verifikasi'])
    ->middleware('throttle:20,1')
    ->name('api.akun-kelurahan.verifikasi');

  Route::get('/{id}', [AkunKelurahanController::class, 'show'])
    ->whereNumber('id')
    ->name('api.akun-kelurahan.show');
});
