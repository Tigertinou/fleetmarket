<?php

namespace App\Services\MotorK;

use Illuminate\Support\Facades\Http;

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
        $query = http_build_query($filters);

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

        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/search?" . $query);

        if ($response->successful()) {
            $json = $response->json();
            $items = $json['response']['searchResults']['models'];
            $res = [
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
        }

        return [];
    }




    // Autres méthodes comme getModels, getSubmodels...
}