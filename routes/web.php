<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleSearchController;
use App\Http\Controllers\VehicleDetailModelController;
use App\Http\Controllers\VehicleDetailSubmodelController;
use App\Http\Controllers\VehicleConfiguratorController;
use App\Http\Controllers\VehicleContactController;
use App\Http\Middleware\SetLocale;

Route::redirect('/', '/fr/');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => 'fr|nl|en'],'middleware' => [SetLocale::class]], function () {
    Route::get('/', function () { return view('pages.home'); })->name('pages.home');

    Route::get('/privacy-policy', function () { return view('pages.legals'); })->name('pages.legals');

    Route::get('/recherche',VehicleSearchController::class)->name('pages.vehicles.search');

    Route::get('/compare', function () {
        return view('pages.vehicles.compare');
    })->name('pages.vehicles.compare');

    Route::get('/elements', function () {
        return view('pages.elements');
    })->name('pages.elements');

    Route::prefix('/partials')->group(function () {
        Route::get('/vehicles/search/results', [VehicleSearchController::class, 'partialResult'])->name('vehicles.search.partial');
        Route::get('/vehicles/configurator/options', [VehicleConfiguratorController::class, 'partialOptions'])->name('vehicles.configurator.options.partial');
        Route::get('/vehicles/contact/form', [VehicleContactController::class, 'partialContactForm'])->name('vehicles.contact.form.partial');
        Route::post('/vehicles/contact/store', [VehicleContactController::class, 'storeContactForm'])->name('vehicles.contact.store');
    });

    Route::get('/{make:slug}/{model:slug}/configurator', VehicleConfiguratorController::class)->name('pages.vehicles.configurator');

    Route::get('/{make:slug}/{model:slug}/{submodel:slug}', VehicleDetailSubmodelController::class)->name('pages.vehicles.detail.submodel');

    Route::get('/{make:slug}/{model:slug}', VehicleDetailModelController::class)->name('pages.vehicles.detail.model');

    Route::get('/{make:slug}', VehicleSearchController::class, 'byMake')->name('pages.vehicles.search.make');

    // Route::get('/{make:slug}/{model:slug}/{version:slug}', [VehicleController::class, 'showVersion'])->name('pages.vehicles.version');

    Route::fallback(function () {
        abort(404);
    });

});
