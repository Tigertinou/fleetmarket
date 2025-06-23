<div class="flex flex-col gap-6">
    {{--{{ var_dump($vehicles) }}--}}
    {{--@dump($vehicles)--}}
    @foreach ( $vehicles['data'] as $key => $vehicle)
        <div class="flex flex-col md:flex-row bg-white shadow-lg md:border-t md:border-r border-gray-100">
            <div class="md:max-w-xs relative">
                <a href="javascript:void(0)" class="rounded-full bg-black text-white icon icon-camera p-1 absolute bottom-3 right-3"></a>
                <img src="{{ $vehicle['model']['covers'][0]['cover500'] }}" class="aspect-3/2 object-cover w-full">
            </div>
            <div class="flex flex-1 flex-col p-4 gap-2">
                <div class="flex-1">
                    <div class="text-2xl font-bold">
                        <h3>{{ $vehicle['model']['makeName'] }} <b class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</b></h3>
                    </div>
                    <p class="text-xs leading-5">
                        @if(isset($vehicle['fuelTypeLabel']))
                            <span class="mr-2 pr-2 border-r last:border-r-0 border-gray-400">
                                <b class="font-semibold uppercase">{{ $vehicle['fuelTypeLabel'] }}</b>
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['co2']['min']))
                            <span class="mr-2 pr-2 border-r last:border-r-0 border-gray-400">
                                CO² : 
                                <b class="font-semibold">{{ $vehicle['summary']['co2']['min'] }}
                                {{ isset($vehicle['summary']['co2']['max']) && $vehicle['summary']['co2']['max'] !== $vehicle['summary']['co2']['min'] ? ' - ' . $vehicle['summary']['co2']['max'] : '' }}</b>
                                {{ $vehicle['summary']['co2']['unitOfMeasure'] }}
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['wltpEmissionsCombined']['min']))
                            <span class="mr-2 pr-2 border-r last:border-r-0 border-gray-400">
                                Émissions WLTP combinées : 
                                <b class="font-semibold">{{ $vehicle['summary']['wltpEmissionsCombined']['min'] }}
                                {{ isset($vehicle['summary']['wltpEmissionsCombined']['max']) && $vehicle['summary']['wltpEmissionsCombined']['max'] !== $vehicle['summary']['wltpEmissionsCombined']['min'] ? ' - ' . $vehicle['summary']['wltpEmissionsCombined']['max'] : '' }}</b>
                                {{ $vehicle['summary']['wltpEmissionsCombined']['unitOfMeasure'] }}
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['wltpConsumptionCombined']['min']))
                            <span class="mr-2 pr-2 border-r last:border-r-0 border-gray-400">
                                Consommation WLTP combinée : 
                                <b class="font-semibold">{{ $vehicle['summary']['wltpConsumptionCombined']['min'] }}
                                {{ isset($vehicle['summary']['wltpConsumptionCombined']['max']) && $vehicle['summary']['wltpConsumptionCombined']['max'] !== $vehicle['summary']['wltpConsumptionCombined']['min'] ? ' - ' . $vehicle['summary']['wltpConsumptionCombined']['max'] : '' }}</b>
                                {{ $vehicle['summary']['wltpConsumptionCombined']['unitOfMeasure'] }}
                            </span>
                        @endif
                        @if(isset($vehicle['summary']['wltpElectricRangeCombinedKm ']['min']))
                            <span class="mr-2 pr-2 border-r last:border-r-0 border-gray-400">
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
                        <div class="text-xs"><span class="font-extrabold text-3xl md:text-2xl mr-1">{{ number_format($vehicle['summary']['minPrice'], 0, ',', '.') . ' €' }}</span> TTC*</div>
                    </div>
                @endif
                <div class="flex md:justify-end flex-col md:flex-row gap-2 items-center border-t border-gray-100 pt-4">
                    <div class="md:flex-1"><a href="" class="text-xs font-semibold underline">Comparer avec un autre vehicule</a></div>
                    {{--<x-utils.button label="Comparer" size="md" icon="icon-car-compare" color="bordered"></x-utils.button>--}}
                    <x-utils.button label="En savoir plus" size="sm" icon="icon-info-circle" r-icon="icon-chevron-right" color="theme" class="flex-1 md:flex-none"></x-utils.button>
                </div>
            </div>
        </div>
    @endforeach

    
</div>


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