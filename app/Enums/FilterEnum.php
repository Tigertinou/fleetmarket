<?php

namespace App\Enums;

use Illuminate\Support\Facades\Cache;
use App\Models\FilterFacet;
use App\Models\Makes;

enum FilterEnum: string
{
    case Makes    = 'makes';
    case FuelType  = 'fueltype';
    case BodyType  = 'bodytype';
    case Gearbox   = 'gearbox';
    case Doors   = 'doors';
    case Seats   = 'seats';
    case Traction = 'traction';
    case PriceMin  = 'price_min';
    case PriceMax  = 'price_max';

    public function label(string $locale = 'fr'): string
    {
        return match ($this) {
            self::Makes    => $locale === 'nl' ? 'Merk' : 'Marque',
            self::FuelType  => $locale === 'nl' ? 'Brandstoftype' : 'Carburant',
            self::BodyType  => $locale === 'nl' ? 'Koetswerk' : 'Type de carrosserie',
            self::Gearbox   => $locale === 'nl' ? 'Versnellingsbak' : 'Boîte de vitesses',
            self::Doors     => $locale === 'nl' ? 'Deuren' : 'Portes',
            self::Seats     => $locale === 'nl' ? 'Zitplaatsen' : 'Sièges',
            self::Traction  => $locale === 'nl' ? 'Aandrijving' : 'Traction',
            self::PriceMin  => $locale === 'nl' ? 'Prijs min' : 'Prix min',
            self::PriceMax  => $locale === 'nl' ? 'Prijs max' : 'Prix max',
        };
    }

    public function filterSearchCode(): string
    {
        return match ($this) {
            self::Makes    => 'makeUrlCode',
            self::FuelType  => 'fuelType',
            self::BodyType  => 'bodyType',
            self::Gearbox   => 'gearboxType',
            self::Doors     => 'doors',
            self::Seats     => 'seats',
            self::Traction  => 'traction',
            self::PriceMin  => 'maxPrice',
            self::PriceMax  => 'minPrice',
        };
    }

    public static function fromCode(string $code): ?self
    {
        return collect(self::cases())
            ->first(fn(self $case) => $case->value === $code);
    }

    public function values(): array
    {
        return match ($this) {
            /* self::Brands => Cache::remember('facet_brands', 3600, function () {
                return Brand::query()
                    ->selectRaw('slug as code, name as label')
                    ->orderBy('name')
                    ->get()
                    ->toArray();
            }), */
            self::FuelType,
            self::BodyType,
            self::Doors,
            self::Seats,
            self::Traction,
            self::Gearbox => Cache::remember("facet_{$this->value}_v2", 3600, function () {
                return FilterFacet::query()
                    ->where('facet_type', $this->value)
                    ->selectRaw('code, value, label_fr as label')
                    ->orderBy('label_fr')
                    ->get()
                    ->toArray();
            }),
            default => [],
        };
    }

    public function getValues(array $codes): array
    {
        $return = [];
        if (empty($codes)) {
            return [];
        }
        foreach ($codes as $code) {
            $get = collect($this->values())->where('code', $code)->values()->toArray();
            if (!empty($get)) {
                $return[] = $get[0];
            } else {
                $return[] = [
                    'code' => $code,
                    'label' => $code,
                ];
            }
        }
        return $return;

    }

}
