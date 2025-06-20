<?php

namespace App\Services;

use App\Models\FilterFacet;
use Illuminate\Support\Facades\Http;

class FacetSyncService
{

    protected string $apiBase;
    protected string $apiKey;

    protected array $facets = [
        'bodyType',
        'seats',
        'fuelType',
        'gearboxType',
        'doors',
        'emissionsClass',
        'traction',
    ];

    public function __construct()
    {
        $this->apiBase = config('motork.api_url');
        $this->apiKey = config('motork.api_key');
    }

    public function sync()
    {
        $response = Http::get("{$this->apiBase}/{$this->apiKey}/car/models", [
            'facets' => implode(',', $this->facets),
            'rows' => 0
        ]);

        if (!$response->ok()) {
            throw new \Exception("API Facet fetch failed");
        }

        $json = $response->json();
        $data = $response['response']['facetResults'] ?? [];

        foreach ($data as $facet => $items) {
            foreach ($items ?? [] as $item) {

                $get = FilterFacet::firstOrNew([
                    'facet_type' => $facet,
                    'value' => $item['value'] ?? '',
                ]);

                if(!$get->exists) {
                    $get->label_fr = $item['value'];
                    $get->label_nl = $this->translate($item['value'], 'nl');
                    $get->label_en = $this->translate($item['value'], 'en');
                }

                $get->count = $item['count'] ?? 0;
                $get->save();

            }
        }
    }

    protected function translate(string $text, string $locale): string
    {
        // Utilise Google Translate API, DeepL, ou un dictionnaire Laravel local
        return __("facets.{$text}", [], $locale);
    }
}
