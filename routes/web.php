<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\SubjectController;


Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/adminPanel', function () {
        return redirect()->route('admin.subjects.index');
    })->name('admin.index');
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::name('subjects.')->prefix('subjects')->group(function () {
            Route::get('/', [SubjectController::class, 'index'])->name('index');
            Route::get('/datatables', [SubjectController::class, 'indexData'])->name('datatables');

            Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('edit');
            Route::post('/{subject}/update', [SubjectController::class, 'update'])->name('update');
            Route::get('/{subject}/delete', [SubjectController::class, 'destroy'])->name('destroy');

            Route::get('/create', [SubjectController::class, 'create'])->name('create');
            Route::post('/store', [SubjectController::class, 'store'])->name('store');
        });

    });
});

Route::post('/importFromExcelFile', [SubjectController::class, 'importFromExcel']);

Route::get('/{any}', function () {
    return view('map.index');
})->where('any', '.*');
