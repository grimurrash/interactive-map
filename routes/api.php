<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\PolygonController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\MuseumController;
use App\Http\Controllers\Api\MuseumTypeController;

Route::middleware('api')->group(function () {
    // map
    Route::get('/museumTypes', [MuseumTypeController::class, 'index']);
    Route::get('/polygons', [PolygonController::class, 'index']);
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/districts', [DistrictController::class, 'index']);
    Route::get('/museums', [MuseumController::class, 'index']);
    Route::get('/museums/show', [MuseumController::class, 'show']);
    Route::get('/museums/search', [MuseumController::class, 'search']);
});
