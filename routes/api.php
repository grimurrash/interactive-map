<?php

use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\SubjectTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\PolygonController;
use App\Http\Controllers\Api\DistrictController;

Route::middleware('api')->group(function () {
    // map
    Route::get('/types', [SubjectTypeController::class, 'index']);
    Route::get('/polygons', [PolygonController::class, 'index']);
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/districts', [DistrictController::class, 'index']);
    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::get('/subjects/show', [SubjectController::class, 'show']);
    Route::get('/subjects/search', [SubjectController::class, 'search']);
});
