<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\ComparisonController;
use App\Http\Controllers\Api\QuoteController;

Route::get('/test', fn() => response()->json(['status' => 'OK']));

Route::prefix('v1')->group(function () {
    Route::get('/makes', [VehicleController::class, 'listMakes']);
    Route::get('/facets/{type}', [VehicleController::class, 'listFacets']);
    Route::get('/models/{make}', [VehicleController::class, 'listModels']);
    Route::get('/submodels/{model}', [VehicleController::class, 'listSubmodels']);
    Route::get('/versions/{submodel}', [VehicleController::class, 'listVersions']);
    Route::get('/version/{id}', [VehicleController::class, 'getVersionDetails']);

    Route::post('/configure/add', [ConfigurationController::class, 'addEquipment']);
    Route::post('/configure/remove', [ConfigurationController::class, 'removeEquipment']);

    Route::post('/compare', [ComparisonController::class, 'compare']);
    Route::post('/quote', [QuoteController::class, 'generateQuote']);
});
