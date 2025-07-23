<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Services\MotorK\MotorKVehicleService;
use App\Enums\FilterEnum;

class VehicleConfiguratorController extends Controller
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

        $motors = collect($vehicle['model']['versions'])
        ->sortBy('price')
        ->groupBy('versionName')
        ->map(function ($versions) {
            return array(
                'trimCode' => $versions->first()['trimCode'],
                'trimName' => $versions->first()['trimName'],
                'versionUrlCode' => $versions->first()['versionUrlCode'],
                'versionName' => $versions->first()['versionName'],
                'versionHistoricalId' => $versions->first()['versionHistoricalId'],
                'price' => $versions->first()['price'],
                'fuelType' => $versions->first()['fuelType'],
                'gearboxType' => $versions->first()['gearboxType'],
                'traction' => $versions->first()['traction'],
                /* 'engineCode' => $version[0]['engineCode'],
                'engineName' => $version[0]['engineName'] */
                );
        });

        $versionHistoricalId = $request->query('version') ?? null;
        $finitionSelected = null;
        $motorSelected = null;

        if(isset($versionHistoricalId)){
            foreach($finitions as $index => $finition){
                if($versionHistoricalId==$finition['versionHistoricalId']){
                    $finitionSelected = $finition['trimCode'];
                }
            }
            foreach($motors as $index => $motor){
                if($versionHistoricalId==$motor['versionHistoricalId']){
                    $motorSelected = $motor['versionUrlCode'];
                }
            }
        }

        return view('pages.vehicles.configurator', compact(
            'vehicle',
            'make',
            'modelId',
            'submodelId',
            'submodelColors',
            'finitions',
            'motors',
            'versionHistoricalId',
            'finitionSelected',
            'motorSelected'
        ));
    }

    public function partialOptions(Request $request, MotorKVehicleService $motorKService)
    {

        $params = $request->query();
        $options = [];

        if(isset($params['versionId'])){
            $results = $motorKService->getEquipments($params['versionId']);
            if($results['status']==200 && count($results['data'] ?? []) > 0){
                $options = $results['data'];
            }
        }

        return response(view('partials.vehicles.configurator.options', compact(
            'options'
        )));

    }
}
