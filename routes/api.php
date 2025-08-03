<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\CaptchaController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Guest\JalanPeduliApiLaporanUserGuest;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//---------------GOOGLE MAP GET KORDINAT--------------------//
Route::get('/kordinat', [MapController::class, 'getCoordinates']);
// ---------------LAPORAN API--------------------//
Route::get('/laporan', [JalanPeduliApiLaporanUserGuest::class, 'index'])->name('api.laporan.index');
Route::get('/laporan/{id_laporan}', [JalanPeduliApiLaporanUserGuest::class, 'show'])->name('api.laporan.show');

// Route POST untuk membuat laporan baru, DENGAN middleware API Key
Route::post('/laporan/upload', [JalanPeduliApiLaporanUserGuest::class, 'store'])
     ->name('api.laporan.store')    
     ->middleware('auth.apikey');
