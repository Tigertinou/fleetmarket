<?php

namespace App\Services;

use App\Models\FilterFacet;
use Illuminate\Support\Facades\Http;

class FacetSyncService
{

    protected string $apiBase = config('motork.api_url');
    protected string $apiKey = config('motork.api_key');

    protected array $facets = [
        'bodyType',
        'seats',
        'fuelType',
        'gearboxType',
        'doors',
        'emissionsClass',
        'traction',
    ];

    public function sync()
    {
        $response = Http::get("{$this->apiBase}{$this->apiKey}/car/models", [
            'facets' => implode(',', $this->facets),
            'rows' => 0
        ]);

        if (!$response->ok()) {
            throw new \Exception("API Facet fetch failed");
        }

        $data = $response->json()['facetCounts'] ?? [];

        foreach ($this->facets as $facet) {
            foreach ($data[$facet] ?? [] as $value) {
                FilterFacet::updateOrCreate(
                    ['facet_type' => $facet, 'value' => $value],
                    [
                        'label_fr' => $value,
                        'label_nl' => $this->translate($value, 'nl'),
                        'label_en' => $this->translate($value, 'en'),
                        'count' => $count ?? 0,
                    ]
                );
            }
        }
    }

    protected function translate(string $text, string $locale): string
    {
        // Utilise Google Translate API, DeepL, ou un dictionnaire Laravel local
        return __("facets.{$text}", [], $locale);
    }
}
