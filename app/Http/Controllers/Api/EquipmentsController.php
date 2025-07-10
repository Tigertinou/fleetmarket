<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MotorK\MotorKVehicleService;
use Illuminate\Http\JsonResponse;

class EquipmentsController extends Controller
{
    public function __construct(protected MotorKVehicleService $service) {}

    public function listEquipments(string $vehicleId): JsonResponse
    {
        return response()->json($this->service->getEquipments($vehicleId));
    }

}
