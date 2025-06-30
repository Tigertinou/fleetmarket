<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Services\MotorK\MotorKVehicleService;
use App\Enums\FilterEnum;

class VehicleSearchController extends Controller
{
    public function __invoke(Request $request, MotorKVehicleService $motorK,  string $lang, string $makeSlug = null, string $modelSlug = null)
    {
        $locale = app()->getLocale();

        $facetTypes = ['fuelType', 'bodyType', 'traction', 'seats', 'doors', 'emissionsClass', 'gearboxType'];
        $facets = [];


        $makes = $motorK->getMakes();

        $make = null;
        if ($makeSlug) {
            $make = collect($makes)->firstWhere('slug', $makeSlug);
            if ($make && $modelSlug) {
                $model = collect($make['models'] ?? [])->firstWhere('slug', $modelSlug);
            }
        }
        // var_dump($make); // Debugging line, can be removed later

        $model = null;

        foreach ($facetTypes as $type) {
            $facets[$type] = FilterFacet::where('facet_type', $type)
                ->orderBy('position')
                ->get()
                ->map(fn($item) => [
                    'value' => $item->code,
                    'label' => $item->{'label_' . $locale} ?? $item->label_en,
                ]);
        }
        $query = $request->query();

        $filters = $this->parseQueryFilters($query);

        return view('pages.vehicles.search', compact('facets','makes','filters', 'make', 'model'))
            ->with('locale', $locale)
            ->with('query', $query);

    }

    public function byMake(Request $request, MotorKVehicleService $motorK, string $lang, string $makeSlug)
    {
        return $this->__invoke($request, $motorK, $lang, $makeSlug);
    }

    public function byMakeModel(Request $request, MotorKVehicleService $motorK, string $lang, string $makeSlug, string $modelSlug)
    {
        return $this->__invoke($request, $motorK, $lang, $makeSlug, $modelSlug);
    }

    public function partialResult(Request $request, MotorKVehicleService $motorKService)
    {

        $filters = $this->parseQueryFilters($request->query());
        /* var_dump($filters); */ // Debugging line, can be removed later
        $vehicles = $motorKService->search($filters ?? []);


        return response(view('partials.vehicles.search.results', compact('vehicles','filters')))
            ->header('X-Total-Count', $vehicles['total'] ?? '')
            ->header('X-Total-Pages', $vehicles['totalPages'] ?? '')
            ->header('X-Current-Page', $vehicles['currentPage'] ?? '')
            ->header('X-Total-Submodels-Count', $vehicles['totalSubmodels'] ?? '')
            ->header('X-Total-Versions-Count', $vehicles['totalVersions'] ?? '')
            ->header('X-Facets', json_encode($this->parseQueryFilters($request->query())));

    }

    public function parseQueryFilters(array $query): array
    {

        $filters = [];
        foreach (FilterEnum::cases() as $facet_type) {
            if(isset($query[$facet_type->value])) {
                $f = [
                    'type' => $facet_type->value,
                    'label' => $facet_type->label( app()->getLocale() ),
                    'values' => $facet_type->getValues(explode(',',$query[$facet_type->value])),
                ];
                switch ($facet_type) {
                    case FilterEnum::Makes:
                        $f['values'] = collect($f['values'])->map(function ($val) {
                            $val['label'] = strtoupper($val['label']);
                            return $val;
                        })->toArray();
                    break;
                    case FilterEnum::PriceMin:
                        $f['values'] = collect($f['values'])->map(function ($val) {
                            $val['label'] = '>= ' . number_format($val['label'], 0, ',', ' ') . ' €';
                            return $val;
                        })->toArray();
                    break;
                    case FilterEnum::PriceMax:
                        $f['values'] = collect($f['values'])->map(function ($val) {
                            $val['label'] = '<= ' . number_format($val['label'], 0, ',', ' ') . ' €';
                            return $val;
                        })->toArray();
                    break;
                    default:
                        $f['values'] = collect($f['values'])->map(function ($val) {
                            $val['label'] = Str::ucfirst($val['label']);
                            return $val;
                        })->toArray();
                    break;
                }
                $filters[] = $f;

            }
        }
        if(isset($query['sort']) && $query['sort'] != '') {
            $filters[] = [ 'type' => 'sort', 'values' => [ [ 'code' => $query['sort'] ] ] ];
        }
        if(isset($query['page']) && $query['page'] != '') {
            $filters[] = [ 'type' => 'page', 'values' => [ [ 'code' => $query['page'] ] ] ];
        }
        if(isset($query['limit']) && $query['limit'] != '') {
            $filters[] = [ 'type' => 'limit', 'values' => [ [ 'code' => $query['limit'] ] ] ];
        }
        if(isset($query['offset']) && $query['offset'] != '') {
            $filters[] = [ 'type' => 'offset', 'values' => [ [ 'code' => $query['offset'] ] ] ];
        }
        if(isset($query['key']) && $query['key'] != '') {
            $filters[] = [ 'type' => 'key', 'values' => [ [ 'code' => $query['key'] ] ] ];
        }

        return $filters;
    }
}

