<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Services\MotorK\MotorKVehicleService;
use App\Enums\FilterEnum;

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
                    'value' => $item->code,
                    'label' => $item->{'label_' . $locale} ?? $item->label_en,
                ]);
        }

        $makes = $motorK->getMakes();

        $filters = $this->parseQueryFilters($request->query());

        return view('pages.vehicles.search', compact('facets','makes','filters'));
    }

    public function partialResult(Request $request, MotorKVehicleService $motorKService)
    {

        $filters = $this->parseQueryFilters($request->query());
        /* var_dump($filters); */ // Debugging line, can be removed later
        $vehicles = $motorKService->search($filters ?? []);


        return response(view('partials.vehicles.search.results', compact('vehicles','filters')))
            ->header('X-Total-Count', $vehicles['total'])
            ->header('X-Total-Pages', $vehicles['totalPages'])
            ->header('X-Current-Page', $vehicles['currentPage'])
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
                    case FilterEnum::Brands:
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

        return $filters;
    }
}

