<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MotorK\MotorKVehicleService;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    public function __construct(protected MotorKVehicleService $service) {}

    public function listMakes(): JsonResponse
    {
        return response()->json($this->service->getMakes());
    }

    // listMakes
    // listModels
    // listSubmodels
    // listVersions
    // getVersionDetails
}
