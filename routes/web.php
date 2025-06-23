<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleSearchController;

Route::redirect('/', '/fr/');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => 'fr|nl|en']], function () {
    Route::get('/', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/recherche',VehicleSearchController::class)->name('pages.vehicles.search');

    Route::get('/compare', function () {
        return view('pages.vehicles.compare');
    })->name('pages.vehicles.compare');

    Route::get('/detail', function () {
        return view('pages.vehicles.detail');
    })->name('pages.vehicles.detail');

    Route::get('/elements', function () {
        return view('pages.elements');
    })->name('pages.elements');

    Route::prefix('/partials')->group(function () {
        Route::get('/vehicles/search/results', [VehicleSearchController::class, 'partialResult'])->name('vehicles.search.partial');
    });
});
