<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{FsicController,FsecController,DashboardController};

Route::redirect('/', 'login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::controller(FsicController::class)
    ->as('fsic.')
    ->prefix('fsic')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/renewal', 'renewalShow')->name('renewal');
        Route::post('/renew', 'renew')->name('renew');
    });
    Route::controller(FsecController::class)
    ->as('fsec.')
    ->prefix('fsec')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/renewal', 'renewalShow')->name('renewal');
        Route::post('/renew', 'renew')->name('renew');
    });
});
