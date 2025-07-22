<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MotorK\MotorKVehicleService;
use Illuminate\Http\JsonResponse;

class ColorsController extends Controller
{
    public function __construct(protected MotorKVehicleService $service) {}

    public function listColors(string $vehicleId): JsonResponse
    {
        return response()->json($this->service->getColors($vehicleId));
    }
}
