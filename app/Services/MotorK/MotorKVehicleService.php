<?php

namespace App\Services\MotorK;

use Illuminate\Support\Facades\Http;
use App\Enums\FilterEnum;

class MotorKVehicleService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('motork.api_url');
        $this->apiKey = config('motork.api_key');
    }

    public function getMakes(): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/makes");
        $json = $response->json();
        $res = [];
        foreach ($json['response'] as $item) {
            $logo = $item['makeLogo'] ?? '';
            if(file_exists(public_path('/assets/images/brands/logo_' . $item['makeUrlCode'] .'.svg'))){
                $logo = asset('/assets/images/brands/logo_' . $item['makeUrlCode'] .'.svg');
            }
            $res[] = [
                'id'   => $item['makeId'] ?? null,
                'name' => $item['makeName'] ?? '',
                'slug' => $item['makeUrlCode'] ?? '',
                'logo' => $logo,
            ];

        }
        return $res;
    }

    public function search(array $filters): array
    {
        $queryParams = [];

        $q = [];

        foreach ($filters as $key => $filter) {
            $facet = FilterEnum::fromCode($filter['type']);
            $type = $facet->filterSearchCode();
            $values = $facet->getValues(collect($filter['values'])->toArray());
            $q[] = '(' . collect($values)->map(function ($e) use ($type) {
                switch ($type) {
                    case 'maxPrice':
                        return "maxPrice:[" . ($e['code']['value'] ?? $e['code']['code'] ?? 0) . " TO *]";
                    case 'minPrice':
                        return "minPrice:[* TO " . ($e['code']['value'] ?? $e['code']['code'] ?? 0) . "]";
                    break;
                    default:
                        return $type . ":" . ($e['code']['value'] ?? $e['code']['code'] ?? '');
                    break;
                }
            })->implode(' OR ') . ')';

        }

        $queryParams['q'] = implode(' AND ', $q);
        $queryParams['rows'] = 20;

        $query = http_build_query($queryParams);

        /*
        Each parameter could be passed via the “q” parameter in query string by this way:
        “?q=$param:$value”

        If you want to add more params:
        “?q=($param1:$value1 AND/OR param2:value2)”

        And if you want to search ranges:
        “?q=$param:[$value1 TO $value2]”

        Additional parameters:
        “withVersions=1” - Return all versions for submodel (versions)2
        “withMedias=1” - Return all media (icon, main image and images)1
        “rows=$numRows” - Choose number of submodels returned.
        “facets=$param” - Choose between params you want to return as facet.

        */
        /* dd($query); */

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/search?" . $query);

        if ($response->successful()) {
            $json = $response->json();
            $items = $json['response']['searchResults']['models'];
            $res = [
                'query' => $queryParams['q'] ?? '',
                'queryParams' => $queryParams,
                'filters' => $filters,
                'total' => $json['response']['numResultFound'] ?? count($items),
                'data' => []
            ];
            foreach ($items as $item) {

                $fuelTag = collect($item['model']['tags'] ?? [])
                    ->firstWhere('dimension', 'Fuel type');
                $item['fuelTypeName'] = $fuelTag['name'] ?? null;
                $item['fuelTypeLabel'] = $fuelTag['translations']['FR'] ?? $item['fuelTypeName'];

                $res['data'][] = $item;
            }

            return $res;
        } else {
            return [
                'query' => $query,
                'filters' => $filters,
                'total' => 0,
                'data' => []
            ];
        }

    }




    // Autres méthodes comme getModels, getSubmodels...
}
