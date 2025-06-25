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
        <div class="flex flex-col bg-white border-gray-100 shadow-lg md:flex-row md:border-t md:border-r">
            <div class="relative md:max-w-xs">
                <a href="javascript:void(0)" class="absolute p-1 text-white bg-black rounded-full icon icon-camera bottom-3 right-3"></a>
                <img src="{{ $vehicle['model']['covers'][0]['cover500'] }}" class="object-cover w-full aspect-3/2">
            </div>
            <div class="flex flex-col flex-1 gap-2 p-4">
                <div class="flex-1">
                    <div class="text-2xl font-bold">
                        <h3>{{ $vehicle['model']['makeName'] }} <b class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</b></h3>
                    </div>
                    <p class="text-xs leading-5">
                        @if(isset($vehicle['fuelTypeLabel']))
                            <span class="pr-2 mr-2 border-r border-gray-400 last:border-r-0">
                                <b class="font-semibold uppercase">{{ $vehicle['fuelTypeLabel'] }}</b>
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['co2']['min']))
                            <span class="pr-2 mr-2 border-r border-gray-400 last:border-r-0">
                                CO² :
                                <b class="font-semibold">{{ $vehicle['summary']['co2']['min'] }}
                                {{ isset($vehicle['summary']['co2']['max']) && $vehicle['summary']['co2']['max'] !== $vehicle['summary']['co2']['min'] ? ' - ' . $vehicle['summary']['co2']['max'] : '' }}</b>
                                {{ $vehicle['summary']['co2']['unitOfMeasure'] }}
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['wltpEmissionsCombined']['min']))
                            <span class="pr-2 mr-2 border-r border-gray-400 last:border-r-0">
                                Émissions WLTP combinées :
                                <b class="font-semibold">{{ $vehicle['summary']['wltpEmissionsCombined']['min'] }}
                                {{ isset($vehicle['summary']['wltpEmissionsCombined']['max']) && $vehicle['summary']['wltpEmissionsCombined']['max'] !== $vehicle['summary']['wltpEmissionsCombined']['min'] ? ' - ' . $vehicle['summary']['wltpEmissionsCombined']['max'] : '' }}</b>
                                {{ $vehicle['summary']['wltpEmissionsCombined']['unitOfMeasure'] }}
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['wltpConsumptionCombined']['min']))
                            <span class="pr-2 mr-2 border-r border-gray-400 last:border-r-0">
                                Consommation WLTP combinée :
                                <b class="font-semibold">{{ $vehicle['summary']['wltpConsumptionCombined']['min'] }}
                                {{ isset($vehicle['summary']['wltpConsumptionCombined']['max']) && $vehicle['summary']['wltpConsumptionCombined']['max'] !== $vehicle['summary']['wltpConsumptionCombined']['min'] ? ' - ' . $vehicle['summary']['wltpConsumptionCombined']['max'] : '' }}</b>
                                {{ $vehicle['summary']['wltpConsumptionCombined']['unitOfMeasure'] }}
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['wltpElectricRangeCombinedKm ']['min']))
                            <span class="pr-2 mr-2 border-r border-gray-400 last:border-r-0">
                                Consommation WLTP combinée :
                                <b class="font-semibold">{{ $vehicle['summary']['wltpElectricRangeCombinedKm ']['min'] }}
                                {{ isset($vehicle['summary']['wltpElectricRangeCombinedKm ']['max']) && $vehicle['summary']['wltpElectricRangeCombinedKm']['max'] !== $vehicle['summary']['wltpElectricRangeCombinedKm']['min'] ? ' - ' . $vehicle['summary']['wltpElectricRangeCombinedKm ']['max'] : '' }}</b>
                                {{ $vehicle['summary']['wltpElectricRangeCombinedKm']['unitOfMeasure'] }}
                            </span>
                        @endif
                    </p>
                </div>
                @if(isset($vehicle['summary']['minPrice']))
                    <div class="flex items-center">
                        <div class="flex-1 text-xs">Prix à partir de</div>
                        <div class="text-xs"><span class="mr-1 text-3xl font-extrabold md:text-2xl">{{ number_format($vehicle['summary']['minPrice'], 0, ',', '.') . ' €' }}</span> TTC*</div>
                    </div>
                @endif
                <div class="flex flex-col items-center gap-2 pt-4 border-t border-gray-100 md:justify-end md:flex-row">
                    <div class="md:flex-1"><a href="" class="text-xs font-semibold underline">Comparer avec un autre vehicule</a></div>
                    {{--<x-utils.button label="Comparer" size="md" icon="icon-car-compare" color="bordered"></x-utils.button>--}}
                    <x-utils.button label="En savoir plus" size="sm" icon="icon-info-circle" r-icon="icon-chevron-right" color="theme" class="flex-1 md:flex-none"></x-utils.button>
                </div>
            </div>
        </div>
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
