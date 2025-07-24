<?php

namespace App\Services\MotorK;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Enums\FilterEnum;


class MotorKVehicleService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('motork.api_url');
        $this->apiKey = config('motork.api_key');
        $this->lang = app()->getLocale();
        $this->availableLang = ['fr', 'en'];
        $this->lang = in_array(Str::lower($this->lang), $this->availableLang) ? Str::lower($this->lang) : 'en';
    }

    public function getMakes(): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/makes?lang={$this->lang}");
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
            'key' => '',
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
                    case 'key':
                        $q[] = '(' .
                        'makeName:*' . $filter['values'][0]['code'] . '*' .
                        ' OR makeName:*' . strtolower($filter['values'][0]['code']) . '*' .
                        ' OR makeName:*' . ucfirst(strtolower($filter['values'][0]['code'])) . '*' .
                        ' OR modelName:*' . $filter['values'][0]['code'] . '*' .
                        ' OR modelName:*' . strtolower($filter['values'][0]['code']) . '*' .
                        ' OR modelName:*' . ucfirst(strtolower($filter['values'][0]['code'])) . '*' .
                        ' OR bodyType:*' . strtolower($filter['values'][0]['code']) . '*' .
                        ')';
                    break;
                }
            }
        }

        $queryParams['q'] = implode(' AND ', $q);

        $query = http_build_query($queryParams);

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/search?{$query}&lang={$this->lang}");
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

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/models?{$query}&lang={$this->lang}");
        $res = [
            'status' => $response->status(),
            'lang' => $this->lang,
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

    public function getSubmodelColors(string $submodelId): array
    {
        $res = [
            'status' => '404',
            'lang' => $this->lang,
            'total' => [],
            'data' => []
        ];
        if (!empty($submodelId)) {
            $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/coloursForSubmodel/{$submodelId}?lang={$this->lang}");
            $res['status'] = $response->status();
            if ($response->successful()) {
                $json = $response->json();
                $res['data'] = $json['response'] ?? [];
                $res['data']['external'] = collect($res['data']['external'])->map(function ($item) {
                    $item['code'] = $item['equipmentId'] ?? Str::slug($item['description']);
                    return $item;
                });
                $res['data']['interior'] = collect($res['data']['interior'])->map(function ($item) {
                    $item['code'] = $item['equipmentId'] ?? Str::slug($item['description']);
                    return $item;
                });
                $res['total']['external'] = count($json['response']['external'] ?? []);
                $res['total']['interior'] = count($json['response']['interior'] ?? []);
            }
        }
        return $res;
    }

    public function getVersionDetails(string $versionId): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/version/{$versionId}?lang={$this->lang}");
        $res = [
            'status' => $response->status(),
            'lang' => $this->lang,
            'data' => []
        ];
        if ($response->successful()) {
            $json = $response->json();
            $res['data'] = $json['response']['searchResults']['versions'][0] ?? [];
        }
        return $res;
    }

    public function getColors(string $versionId): array
    {
        $res = [
            'status' => 404,
            'lang' => $this->lang,
            'data' => []
        ];
        if(isset($versionId)){
            $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/colours/{$versionId}?lang={$this->lang}");
            $res['status'] = $response->status();
            if ($response->successful()) {
                $json = $response->json();
                $res['data'] = $json['response'] ?? [];
            }
        }
        return $res;
    }

    public function getEquipments(string $versionId): array
    {
        $res = [
            'status' => 404,
            'lang' => $this->lang,
            'data' => []
        ];
        if(isset($versionId)){
            $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/equipments/{$versionId}?lang={$this->lang}");
            $res['status'] = $response->status();
            if ($response->successful()) {
                $json = $response->json();
                $res['data'] = $json['response'] ?? [];
            }
        }
        return $res;
    }

    public function addEquipment(string $versionId, string $equipmentId, string $config = '')
    {
        $res = [
            'status' => 404,
            'lang' => $this->lang,
            'data' => []
        ];
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/equipments/{$versionId}/add", [
            'lang' => $this->lang,
            'toAdd' => $equipmentId,
            'config' => $config,
        ]);
        $res['status'] = $response->status();
        if ($response->successful()) {
            $json = $response->json();
            $res['data'] = $json['response'] ?? [];
            $res['versionId'] = $versionId ?? '';
            $res['idEquipment'] = $equipmentId ?? '';
            $res['config'] = $config ?? '';
        }
        return $res;
    }

    public function removeEquipment(string $versionId, string $equipmentId, string $config = '')
    {
        $res = [
            'status' => 404,
            'lang' => $this->lang,
            'data' => []
        ];
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/equipments/{$versionId}/remove", [
            'lang' => $this->lang,
            'toRemove' => $equipmentId,
            'config' => $config,
        ]);
        $res['status'] = $response->status();
        if ($response->successful()) {
            $json = $response->json();
            $res['data'] = $json['response'] ?? [];
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
