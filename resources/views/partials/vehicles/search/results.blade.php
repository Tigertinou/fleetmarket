<div class="flex flex-col gap-6">
    @if(!isset($vehicles['data']) || count($vehicles['data']) === 0)
        <div class="flex items-center justify-center w-full h-64">
            <div class="text-center">
                <h2 class="text-2xl font-bold">Aucun véhicule trouvé</h2>
                <p class="text-sm">Essayez de modifier vos critères de recherche.</p>
            </div>
        </div>
        {{-- <pre>{{ json_encode($vehicles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
    @endif
    {{-- <pre>{{ json_encode($vehicles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
    {{-- <pre>{{ $vehicles['query'] }}</pre> --}}
    {{-- <pre>{{ $vehicles['query'] }}</pre> --}}
    {{-- <pre>{{ json_encode($vehicles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
    {{-- {{ $vehicles['query'] }} --}}
    {{--<pre>{{ json_encode($vehicles['queryParams'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>--}}
    @foreach ( $vehicles['data'] as $key => $vehicle)
        <x-vehicles.card :vehicle="$vehicle" :show-compare-button="true" :show-more-button="true" />

        
    @endforeach
</div>
<div class="pt-4">
    <x-utils.pagination :total-pages="$vehicles['totalPages']" :per-page="$vehicles['perPage']" :current-page="$vehicles['currentPage']" :total="$vehicles['total']"/>
</div>
{{-- <pre>{{ json_encode($vehicles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
{{-- <pre>{{ json_encode($vehicles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
{{--

<pre>{{ json_encode($vehicles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
Prix (min-max) (minPrice / maxPrice) — prix catalogue

Type de carburant (fuelType)

Consommation WLTP combinée (si dispo) :

wltpConsumptionCombined ou wltpConsumptionCombiL100Km (min–max) l/100km

Émissions WLTP combinées :

wltpEmissionsCombined (min–max) g/km

Autonomie électrique (si VE ou hybride) :

wltpElectricRangeCombinedKm (min–max) km

Transmission (gearboxType)

Nombre de portes (doors) et places (seats)
--}}
