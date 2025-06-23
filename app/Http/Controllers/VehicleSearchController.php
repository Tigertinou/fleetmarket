<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Services\MotorK\MotorKVehicleService;

class VehicleSearchController extends Controller
{
    public function __invoke(Request $request, MotorKVehicleService $motorK)
    {
        $locale = app()->getLocale();

        $facetTypes = ['fuelType', 'bodyType', 'traction', 'seats', 'doors', 'emissionsClass', 'gearboxType'];
        $facets = [];

        foreach ($facetTypes as $type) {
            $facets[$type] = FilterFacet::where('facet_type', $type)
                ->orderBy('position')
                ->get()
                ->map(fn($item) => [
                    'value' => $item->value,
                    'label' => $item->{'label_' . $locale} ?? $item->label_en,
                ]);
        }

        $makes = $motorK->getMakes();

        return view('pages.vehicles.search', compact('facets','makes'));
    }

    public function partialResult(Request $request, MotorKVehicleService $motorKService)
    {
        /* $filters = $request->only(['make', 'fuel', 'bodyType']);*/
        $vehicles = $motorKService->search($filters ?? []);

        return response(view('partials.vehicles.search.results', compact('vehicles')))
            ->header('X-Total-Count', $vehicles['total']);

    }
}

