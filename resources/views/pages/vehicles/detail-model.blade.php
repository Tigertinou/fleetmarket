@php
$vehicle = $vehicles['data'][0];
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.search.make', [ 'make' => $vehicle['model']['makeUrlCode'] ]), 'label' => $vehicle['model']['makeName'], 'class' => 'font-semibold text-black'],
    ['label' => $vehicle['model']['modelName'] ]
];
@endphp
@push(\App\Support\Stack::COVER)
    <div>
        <div>
            <img src="{{ $vehicle['model']['covers'][0]['cover1600'] }}" class="hidden object-cover w-full md:block">
            <img src="{{ $vehicle['model']['covers'][0]['cover500'] }}" class="object-cover w-full md:hidden">
        </div>
    </div>
@endpush
<x-layouts.app :title="'Page'" :$breadcrumb>

    <x-utils.container>
        <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
            <div class="flex flex-col items-center md:gap-4 md:flex-row">
                <img src="{{ $make['logo'] }}" class="w-30 md:w-24">
                <div class="flex-1">
                    <h1 class="h1" style="margin:0;">
                        <span class="text-4xl">{{ $vehicle['model']['makeName'] }} <b class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</b></span></h1>
                    {{-- <p class="text-sm md:text-md">Découvrez les modèles de la marque {{ $make['name'] }} disponibles en Belgique, {{ strftime('%B %Y') }}</p> --}}
                </div>
            </div>
            <x-utils.button label="Configurez votre voiture" size="md" r-icon="icon-chevron-right" color="theme" class="flex-1 md:flex-none min-w-80"></x-utils.button>
        </div>
        <pre>{{ json_encode($vehicle, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </x-utils.container>

</x-layouts.app>
