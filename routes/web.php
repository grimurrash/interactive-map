<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\MuseumController;


Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//    Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/adminPanel', function () {
        return redirect()->route('admin.museums.index');
    });
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::name('museums.')->prefix('museums')->group(function () {
            Route::get('/', [MuseumController::class, 'index'])->name('index');
            Route::get('/datatables', [MuseumController::class, 'indexData'])->name('datatables');

            Route::get('/{museum}/edit', [MuseumController::class, 'edit'])->name('edit');
            Route::post('/{museum}/update', [MuseumController::class, 'update'])->name('update');
            Route::get('/{museum}/delete', [MuseumController::class, 'destroy'])->name('destroy');

            Route::get('/create', [MuseumController::class, 'create'])->name('create');
            Route::post('/store', [MuseumController::class, 'store'])->name('store');
        });
    });
});

Route::post('/importFromExcelFile', [MuseumController::class, 'importFromExcel']);

//Route::get('/', function () {
//    return view('map.index');
//});

Route::get('/{any}', function () {
    return view('map.index');
})->where('any', '.*');
