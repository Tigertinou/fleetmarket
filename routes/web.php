<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fr/');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => 'fr|nl|en']], function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});
