<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ColorsController;
use App\Http\Controllers\Api\EquipmentsController;
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

    Route::get('/colors/{vehicleId}', [ColorsController::class, 'listColors']);

    Route::get('/equipments/{vehicleId}', [EquipmentsController::class, 'listEquipments']);
    Route::post('/equipments/{vehicleId}/add', [EquipmentsController::class, 'addEquipment']);
    Route::post('/equipments/{vehicleId}/remove', [EquipmentsController::class, 'removeEquipment']);

    Route::post('/compare', [ComparisonController::class, 'compare']);
    Route::post('/quote', [QuoteController::class, 'generateQuote']);
});
