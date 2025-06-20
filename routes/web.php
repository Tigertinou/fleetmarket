<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fr/');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => 'fr|nl|en']], function () {
    Route::get('/', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/recherche', function () {
        return view('pages.vehicles.search');
    })->name('pages.vehicles.search');

    Route::get('/compare', function () {
        return view('pages.vehicles.compare');
    })->name('pages.vehicles.compare');

    Route::get('/detail', function () {
        return view('pages.vehicles.detail');
    })->name('pages.vehicles.detail');

    Route::get('/elements', function () {
        return view('pages.elements');
    })->name('pages.elements');
});
