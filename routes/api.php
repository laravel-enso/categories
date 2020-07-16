<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'core'])
    ->group(function () {
        Route::namespace('LaravelEnso\Categories\Http\Controllers')
            ->prefix('api/administration/categories')
            ->as('administration.categories.')
            ->group(function () {
                Route::get('', 'Index')->name('index');
                Route::post('', 'Store')->name('store');
                Route::patch('{category}/move', 'Move')->name('move');
                Route::patch('{category}', 'Update')->name('update');
                Route::delete('{category}', 'Destroy')->name('destroy');
            });
    });
