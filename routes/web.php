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

    Route::get('/elements', function () {
        return view('pages.elements');
    })->name('pages.elements');

    Route::prefix('/partials')->group(function () {
        Route::get('/vehicles/search/results', [VehicleSearchController::class, 'partialResult'])->name('vehicles.search.partial');
    });

    Route::get('/{brand}', [VehicleSearchController::class, 'byBrand'])->name('pages.vehicles.search.brand');

    Route::get('/{brand}/{model}', [VehicleSearchController::class, 'byBrandModel'])->name('pages.vehicles.search.brand.model');

    Route::get('/{brand}/{model}/{version}', [VehicleController::class, 'showVersion'])->name('pages.vehicles.version');
});
