<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Services\MotorK\MotorKVehicleService;
use App\Enums\FilterEnum;

class VehicleDetailModelController extends Controller
{
    public function __invoke(Request $request, MotorKVehicleService $motorK,  string $lang, string $makeSlug = null, string $modelSlug = null)
    {
        $locale = app()->getLocale();

        // $makes = $motorK->getMakes();
        $makes = $motorK->getMakes();

        $make = null;
        if ($makeSlug) {
            $make = collect($makes)->firstWhere('slug', $makeSlug);
            if ($make && $modelSlug) {
                $model = collect($make['models'] ?? [])->firstWhere('slug', $modelSlug);
            }
        }

        $vehicles = $motorK->getModelBySlug($makeSlug, $modelSlug);

        if( !$vehicles || empty($vehicles['data']) ) {
            abort(404, 'Model not found');
        }
        $vehicle = $vehicles['data'][0];
        $modelId = $vehicle['model']['modelId'] ?? null;
        $submodelId = $vehicle['model']['submodelId'] ?? null;

        $submodelColors = $motorK->getSubmodelColors($submodelId);

        $finitions = collect($vehicle['model']['versions'])
        ->sortBy('price')
        ->groupBy('trimName')
        ->map(function ($versions) {
            return array(
                'trimCode' => $versions->first()['trimCode'],
                'trimName' => $versions->first()['trimName'],
                'versionHistoricalId' => $versions->first()['versionHistoricalId'],
                'price' => $versions->first()['price'],
                'fuelTypes' => $versions->pluck('fuelType')->unique()->values()->all(),
                'versionUrlCode' => $versions->first()['versionUrlCode'],
                );
        });
        //$vehicle = null;

        return view('pages.vehicles.detail-model', compact(
            'vehicle',
            'make',
            'modelId',
            'submodelId',
            'vehicles',
            'submodelColors',
            'finitions',
        ));
    }
}
