<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Services\MotorK\MotorKVehicleService;
use App\Enums\FilterEnum;

class VehicleDetailSubmodelController extends Controller
{
    public function __invoke(Request $request, MotorKVehicleService $motorK,  string $lang, string $makeSlug = null, string $submodelSlug = null)
    {

    }


}
