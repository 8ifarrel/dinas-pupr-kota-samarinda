<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\CaptchaController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\TensorFlowModelController;
use App\Http\Controllers\Api\TensorFlowTestController;
use App\Http\Controllers\Guest\JalanPeduliApiLaporanUserGuest;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
