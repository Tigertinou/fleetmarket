<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MotorK\MotorKVehicleService;
use Illuminate\Http\JsonResponse;
use App\Models\FilterFacet;

class VehicleController extends Controller
{
    public function __construct(protected MotorKVehicleService $service) {}

    public function listMakes(): JsonResponse
    {
        return response()->json($this->service->getMakes());
    }

    public function listFacets(string $type){

        $facets = FilterFacet::where('facet_type', $type)
            ->orderBy('position')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->value,
                    'label' => [
                        'en' => $item->label_en,
                        'fr' => $item->label_fr,
                        'nl' => $item->label_nl,
                    ],
                    'count' => $item->count,
                    'position' => $item->position,
                ];
            });

        return response()->json($facets);
    }
    // listMakes
    // listModels
    // listSubmodels
    // listVersions
    // getVersionDetails
}
