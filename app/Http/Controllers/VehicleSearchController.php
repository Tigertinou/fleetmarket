<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilterFacet;

class VehicleSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $locale = app()->getLocale();

        $facetTypes = ['fuelType', 'bodyType', 'gearboxType', 'seats'];
        $facets = [];

        foreach ($facetTypes as $type) {
            $facets[$type] = FilterFacet::where('facet_type', $type)
                ->orderBy('position')
                ->get()
                ->map(fn($item) => [
                    'value' => $item->value,
                    'label' => $item->{'label_' . $locale} ?? $item->label_en,
                ]);
        }

        return view('pages.vehicles.search', compact('facets'));
    }
}

