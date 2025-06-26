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
        $queryParams = [
            'rows' => 10,
            'start' => 0,
            'withVersions' => 1,
            'withMedias' => 1,
            'facets' => '',
            'q' => '',
            'sort' => '',
        ];

        $q = [];

        usort($filters, function ($a, $b) {
             return ($a['type'] == 'page') <=> ($b['type'] == 'page');
        });

        foreach ($filters as $key => $filter) {
            $facet = FilterEnum::fromCode($filter['type']);
            if ($facet) {
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
            } else {
                switch ($filter['type']) {
                    case 'sort':
                        $queryParams['sort'] = $filter['values'][0]['code'] ?? '';
                    break;
                    case 'page':
                        $queryParams['start'] = ((int)($filter['values'][0]['code'] ?? 1) * $queryParams['rows'])- $queryParams['rows'];
                    break;
                    case 'limit':
                        $queryParams['rows'] = (int)($filter['values'][0]['code'] ?? 10);
                    break;
                    case 'offset':
                        $queryParams['start'] = (int)($filter['values'][0]['code'] ?? 0);
                    break;
                    case 'facets':
                        $queryParams['facets'] = implode(',', $filter['values']);
                    break;
                    case 'withVersions':
                        $queryParams['withVersions'] = (int)($filter['values'][0]['code'] ?? 1);
                    break;
                    case 'withMedias':
                        $queryParams['withMedias'] = (int)($filter['values'][0]['code'] ?? 1);
                    break;
                }
            }
        }

        $queryParams['q'] = implode(' AND ', $q);

        $query = http_build_query($queryParams);

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/search?" . $query);
        $res = [
            'status' => $response->status(),
            'total' => 0,
            'totalSubmodels' => 0,
            'totalVersions' => 0,
            'currentPage' => 0,
            'totalPages' => 0,
            'perPage' => $queryParams['rows'],
            'query' => $query,
            'queryParams' => $queryParams,
            'filters' => $filters,
            'data' => []
        ];
        if ($response->successful()) {
            $json = $response->json();
            $items = $json['response']['searchResults']['models'];
            $res = array_merge($res, [
                'status' => $response->status(),
                'total' => $json['response']['numGroupedFound'] ?? count($items),
                'totalSubmodels' => $json['response']['numResultFound'] ?? 0,
                'totalVersions' => $json['response']['numVersionsFound'] ?? 0,
                'currentPage' => floor($queryParams['start'] / $queryParams['rows']) + 1,
                'totalPages' => ceil(($json['response']['numGroupedFound'] ?? count($items)) / $queryParams['rows'])
            ]);
            foreach ($items as $item) {

                $fuelTag = collect($item['model']['tags'] ?? [])
                    ->firstWhere('dimension', 'Fuel type');
                $item['fuelTypeName'] = $fuelTag['name'] ?? null;
                $item['fuelTypeLabel'] = $fuelTag['translations']['FR'] ?? $item['fuelTypeName'];

                $res['data'][] = $item;
            }
        }
        return $res;
    }

    public function getModelBySlug(string $makeSlug, $modelSlug): array
    {
        $queryParams = [
            'withVersions' => 1,
            'withMedias' => 1,
            'q' => '',
        ];
        $q = [];
        $q[] = "makeUrlCode:{$makeSlug}";
        $q[] = "modelUrlCode:{$modelSlug}";

        $queryParams['q'] = implode(' AND ', $q);
        $query = http_build_query($queryParams);

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/models?" . $query);
        $res = [
            'status' => $response->status(),
            'total' => 0,
            'totalVersions' => 0,
            'data' => []
        ];
        if ($response->successful()) {
            $json = $response->json();
            $items = $json['response']['searchResults']['models'];
            $res = array_merge($res, [
                'status' => $response->status(),
                'total' => $json['response']['numGroupedFound'] ?? count($items),
                'totalVersions' => $json['response']['numVersionsFound'] ?? 0
            ]);
            foreach ($items as $item) {
                $res['data'][] = $item;
            }
        }
        return $res;
    }

   /*  public function getSubmodel(string $submodelSlug): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/models/{$makeSlug}");
        $json = $response->json();
        $res = [];
        foreach ($json['response'] as $item) {
            $res['data'][] = $item;
        }
        return $res;
    } */



    // Autres méthodes comme getModels, getSubmodels...
}


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
