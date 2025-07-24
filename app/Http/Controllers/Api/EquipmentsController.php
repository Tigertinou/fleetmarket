<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MotorK\MotorKVehicleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EquipmentsController extends Controller
{
    public function __construct(protected MotorKVehicleService $service) {}

    public function listEquipments(Request $request,  string $lang, string $vehicleId): JsonResponse
    {
        return response()->json($this->service->getEquipments($vehicleId));
    }

    public function addEquipment(Request $request,  string $lang, string $vehicleId): JsonResponse
    {

        $data = request()->validate([
            'idEquipment' => 'required|string',
            'config' => 'nullable|string',
        ]);

        $result = $this->service->addEquipment($vehicleId, $data['idEquipment'], $data['config'] ?? '');
        if ($result) {
            return response()->json($result);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to add equipment'], 400);
    }

    public function removeEquipment(Request $request,  string $lang, string $vehicleId): JsonResponse
    {
        $data = request()->validate([
            'idEquipment' => 'required|string',
            'config' => 'nullable|string',
        ]);

        $result = $this->service->removeEquipment($vehicleId, $data['idEquipment'], $data['config'] ?? '');
        if ($result) {
            return response()->json($result);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to remove equipment'], 400);
    }
}
