<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fr/');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => 'fr|nl|en']], function () {
    Route::get('/', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/search', function () {
        return view('pages.search');
    })->name('pages.search');

    Route::get('/elements', function () {
        return view('pages.elements');
    })->name('pages.elements');
});
