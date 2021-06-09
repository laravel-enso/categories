<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Categories\Http\Controllers\Destroy;
use LaravelEnso\Categories\Http\Controllers\Index;
use LaravelEnso\Categories\Http\Controllers\Move;
use LaravelEnso\Categories\Http\Controllers\Store;
use LaravelEnso\Categories\Http\Controllers\Update;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/administration/categories')
    ->as('administration.categories.')
    ->group(function () {
        Route::get('', Index::class)->name('index');
        Route::post('', Store::class)->name('store');
        Route::patch('{category}/move', Move::class)->name('move');
        Route::patch('{category}', Update::class)->name('update');
        Route::delete('{category}', Destroy::class)->name('destroy');
    });
