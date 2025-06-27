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

        $modelId = $vehicles['data'][0]['model']['modelId'] ?? null;
        $submodelId = $vehicles['data'][0]['model']['submodelId'] ?? null;

        $submodeColors = $motorK->getSubmodelColors($submodelId);

        //$vehicle = null;

        return view('pages.vehicles.detail-model', compact( 'make', 'modelId', 'submodelId', 'vehicles', 'submodeColors' ));
    }
}
