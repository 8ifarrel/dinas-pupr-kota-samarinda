<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\CaptchaController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\TensorFlowModelController;
use App\Http\Controllers\Api\TensorFlowTestController;
use App\Http\Controllers\Guest\JalanPeduliApiLaporanUserGuest;
use App\Http\Controllers\Api\ApiKeyController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//---------------API KEY MANAGEMENT--------------------//
// HANYA untuk super admin yang sudah login via web interface
Route::prefix('keys')->middleware(['web'])->group(function () {
    // Middleware khusus untuk memastikan user adalah super admin
    Route::middleware(\App\Http\Middleware\RedirectIfNotAuthenticated::class, \App\Http\Middleware\IsSuperAdmin::class)->group(function () {
        Route::get('/', [ApiKeyController::class, 'index'])->name('api.keys.index');
        Route::post('/', [ApiKeyController::class, 'store'])->name('api.keys.store');
        Route::get('/{id}', [ApiKeyController::class, 'show'])->name('api.keys.show');
        Route::put('/{id}', [ApiKeyController::class, 'update'])->name('api.keys.update');
        Route::delete('/{id}', [ApiKeyController::class, 'destroy'])->name('api.keys.destroy');
        Route::post('/{id}/regenerate', [ApiKeyController::class, 'regenerate'])->name('api.keys.regenerate');
        Route::get('/{id}/usage', [ApiKeyController::class, 'getUsageStats'])->name('api.keys.usage');
    });
    
    // Route validate bisa diakses oleh siapa saja (untuk testing API key)
    Route::post('/validate', [ApiKeyController::class, 'validate'])->name('api.keys.validate');
});

//---------------GOOGLE MAP GET KORDINAT--------------------//
Route::get('/kordinat', [MapController::class, 'getCoordinates']);

//---------------MACHINE LEARNING MODEL API--------------------//
Route::get('/ml/model-info', [TensorFlowModelController::class, 'getModelInfo'])->name('api.ml.model-info');
Route::get('/ml/health', [TensorFlowModelController::class, 'checkModelHealth'])->name('api.ml.health');

//---------------SERVER TENSORFLOW.JS TESTING--------------------//
Route::get('/tensorflow/status', [TensorFlowTestController::class, 'testService'])->name('api.tensorflow.status');
Route::post('/tensorflow/predict', [TensorFlowTestController::class, 'testPrediction'])->name('api.tensorflow.predict');

// ---------------LAPORAN API--------------------//
Route::get('/laporan', [JalanPeduliApiLaporanUserGuest::class, 'index'])->name('api.laporan.index');
Route::get('/laporan/{id_laporan}', [JalanPeduliApiLaporanUserGuest::class, 'show'])->name('api.laporan.show');

// Route POST untuk membuat laporan baru, DENGAN middleware API Key
Route::post('/laporan/upload', [JalanPeduliApiLaporanUserGuest::class, 'store'])
     ->name('api.laporan.store')    
     ->middleware('auth.apikey');
