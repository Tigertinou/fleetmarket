<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MotorK\MotorKVehicleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ColorsController extends Controller
{
    public function __construct(protected MotorKVehicleService $service) {}

    public function listColors(Request $request,  string $lang, string $vehicleId): JsonResponse
    {
        return response()->json($this->service->getColors($vehicleId, $lang));
    }
}
