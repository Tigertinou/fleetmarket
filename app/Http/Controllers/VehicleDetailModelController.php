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

        //$vehicle = null;

        return view('pages.vehicles.detail-model', compact( 'make','vehicles' ));
    }
}
