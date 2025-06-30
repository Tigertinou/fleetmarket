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
        <div class="relative">
            <img src="{{ $make['logo'] }}" class="absolute w-10 md:w-24 md:order-1 invert right-4 top-4" alt="{{ $vehicle['model']['makeName'] }} logo">
            <img src="{{ $vehicle['model']['covers'][0]['cover1600'] }}" class="hidden object-cover w-full md:block">
            <img src="{{ $vehicle['model']['covers'][0]['cover500'] }}" class="object-cover w-full md:hidden">
        </div>
    </div>
@endpush

<x-layouts.app :title="'Page'" :$breadcrumb>

    <x-utils.container class="border-b border-gray-200">
        <div class="flex flex-col items-center justify-between -my-2 md:gap-4 md:flex-row">
            <div class="flex flex-row items-center w-full my-4 md:gap-4 justify-beetween md:w-auto">
                <div class="flex-1 md:order-2">
                    <h1 class="flex flex-wrap gap-x-2 h1" style="margin:0;">
                        <span>{{ $vehicle['model']['makeName'] }}</span>
                        <span><b class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</b></span>
                    </h1>
                    <p>
                        @if(isset($vehicle['summary']['numVersions']))
                            <span class="text-xs font-light underline">Disponible en {{ $vehicle['summary']['numVersions'] }} versions</span>
                        @endif
                    </p>
                </div>
                <img src="{{ $make['logo'] }}" class="self-start w-20 md:w-24 md:order-1" alt="{{ $vehicle['model']['makeName'] }} logo">
            </div>
            @if(isset($vehicle['summary']['minPrice']))
                <div class="flex items-center w-full gap-4 md:w-auto">
                    <div class="flex-1 text-xs">Prix à partir de</div>
                    <div class="text-xs"><a href="#versions" class="mr-1 text-3xl font-extrabold md:text-3xl">{{ number_format($vehicle['summary']['minPrice'], 0, ',', '.') . ' €' }}</a> TTC*</div>
                </div>
            @endif
        </div>
    </x-utils.container>

    <x-utils.container class="py-6">
        <div class="text-center md:text-left">
            <h2 class="mb-2 text-2xl">Configurez votre voiture</h2>
            <p class="text-xs md:text-sm">Choisissez la finition, le moteur ainsi que toutes les options pour votre nouveau vehicule.</p>
            <div class="flex flex-col gap-4 mt-6 md:flex-row">
                <x-utils.box color="bordered" class="flex-1 w-full cursor-pointer hover:outline-2 hover:outline-theme">
                    <span class="block -mb-1 text-xs text-gray-400 uppercase font-extralight">Finition</span>
                    Sélectionner la <b class="font-semibold">finition</b>
                </x-utils.box>
                <x-utils.box color="bordered" class="flex-1 w-full cursor-pointer hover:outline-2 hover:outline-theme">
                    <span class="block -mb-1 text-xs text-gray-400 uppercase font-extralight">Moteur</span>
                    Sélectionner le <b class="font-semibold">moteur</b>
                </x-utils.box>
                <x-utils.button size="md" color="theme" class="flex-1 w-full" align="center">
                    Configurez votre <b class="font-semibold">voiture</b><br>
                </x-utils.button>
            </div>
        </div>
    </x-utils.container>

    <x-vehicles.gallery :images="$vehicle['model']['images']" />

    @if(isset($submodeColors) && isset($submodeColors['data']['external']) && count($submodeColors['data']['external']) > 0)
        <x-utils.container class="py-4 md:py-2">
            <div>
                <h2 class="mb-6 text-2xl text-center md:text-left">Couleurs</h2>
                <x-vehicles.colors-selector :colors="$submodeColors['data']['external']"></x-vehicles.colors-selector>
            </div>
        </x-utils.container>
    @endif

    <x-utils.container class="py-4 bg-gray-100 md:py-2">
        <div>
            <h2 class="mb-6 text-2xl text-center md:text-left">Spécifications techniques</h2>
            <div class="mb-4 text-xs md:text-base">
                @php
                    $specs = array(
                        'min_power_hp' => null,
                        'max_power_hp' => null,
                        'min_power_kw' => null,
                        'max_power_kw' => null,
                        'min_co2' => null,
                        'max_co2' => null,
                        'min_cyl' => null,
                        'max_cyl' => null,
                        'min_consumption' => null,
                        'max_consumption' => null,
                        'min_autonomy' => null,
                        'max_autonomy' => null,
                        'min_electric_consumption' => null,
                        'max_electric_consumption' => 0
                    );
                    [$specs['min_power_hp'], $specs['max_power_hp']] = minmax(array_map(fn($v) => $v['engine']['HP'] ?? null, $vehicle['model']['versions'])) ?? [null, null];
                    [$specs['min_power_kw'], $specs['max_power_kw']] = minmax(array_map(fn($v) => $v['engine']['kw'] ?? null, $vehicle['model']['versions'])) ?? [null, null];
                    [$specs['min_co2'], $specs['max_co2']] = minmax(array_map(fn($v) => $v['omologation']['emissions']['combined'] ?? null, $vehicle['model']['versions'])) ?? [null, null];
                    [$specs['min_cyl'], $specs['max_cyl']] = minmax(array_map(fn($v) => $v['engine']['cm3'] ?? null, $vehicle['model']['versions'])) ?? [null, null];
                    [$specs['min_consumption'], $specs['max_consumption']] = minmax(array_map(fn($v) => $v['omologation']['consumption']['combined'] ?? $v['consumption']['combined'] ?? null, $vehicle['model']['versions'])) ?? [null, null];
                    [$specs['min_autonomy'], $specs['max_autonomy']] = minmax(array_map(fn($v) => $v['battery']['autonomy'] ?? $v['omologation']['range']['combined'] ?? null, $vehicle['model']['versions'])) ?? [null, null];
                    [$specs['min_electric_consumption'], $specs['max_electric_consumption']] = minmax(array_map(fn($v) => $v['omologation']['electricConsumption']['combined'] ?? null, $vehicle['model']['versions'])) ?? [null, 0];
                @endphp
                <ul class="flex flex-col cursor-default gap-y-2 gap-x-1 specs-list">
                    <li class=" hover:bg-gray-200 hover:outline-4 outline-gray-200">
                        <span>Puissance</span>
                        <span class="dots"></span>
                        <span class="font-normal">{{ $specs['min_power_hp'] }} - {{ $specs['max_power_hp'] }} <small>HP</small> / {{ $specs['min_power_kw'] }} - {{ $specs['max_power_kw'] }} <small>CV</small></span>
                    </li>
                    <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
                        <span>Émissions de CO2</span>
                        <span class="dots"></span>
                        <span class="font-normal">{{ $specs['min_co2'] }} - {{ $specs['max_co2'] }} <small>g/Km**</small></span>
                    </li>
                    <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
                        <span>Cylindrée</span>
                        <span class="dots"></span>
                        <span class="font-normal">{{ $specs['min_cyl'] }} - {{ $specs['max_cyl'] }} <small>cm3</small></span>
                    </li>
                    <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
                        <span>Consommation de carburant mixte</span>
                        <span class="dots"></span>
                        <span class="font-normal">{{ $specs['min_consumption'] }} - {{ $specs['max_consumption'] }} <small>l/100km**</small></span>
                    </li>
                    <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
                        <span>Autonomie</span>
                        <span class="dots"></span>
                        <span class="font-normal">{{ $specs['min_autonomy'] }} - {{ $specs['max_autonomy'] }} <small>Km</small></span>
                    </li>
                    <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
                        <span>Consommation électrique mixte</span>
                        <span class="dots"></span>
                        <span class="font-normal">{{ $specs['min_electric_consumption'] }} - {{ $specs['max_electric_consumption'] }} <small>kWh/100km**</small></span>
                    </li>
                </ul>
            </div>
        </div>
    </x-utils.container>

    <div class="px-0 py-6 mx-auto overflow-hidden">
        <div>
            <div class="px-4 m-auto text-center md:text-left md:max-w-screen-xl">
                <h2 class="text-2xl">Finitions</h2>
                <p class="text-xs md:text-sm">Choisissez votre finition et commencez à configurer votre {{ $vehicle['model']['makeName'] }}</p>
            </div>
            @php
                $finitions = collect($vehicle['model']['versions'])
                ->groupBy('trimName')
                ->map(function ($versions) {
                    return $versions->min('price');
                });
            @endphp
            <div x-data="{
                init() {
                    this.scroller = $el.children[0];
                    this.scroller.scrollTo(0,0);
                },
                back () {
                    this.scroller.scrollBy({
                        left: -this.scroller.clientWidth,
                        behavior: 'smooth'
                    });
                },
                next () {
                    this.scroller.scrollBy({
                        left: this.scroller.clientWidth,
                        behavior: 'smooth'
                    });
                }
            }" class="flex flex-col @if($finitions->count() < 4) md:max-w-screen-xl mx-auto @endif">
            {{-- <div class="flex flex-col h-120 md:h-96"> --}}
            {{-- <div class="flex flex-col h-80"> --}}
            <div class="flex-1 max-w-full overflow-auto cursor-pointer select-none snap-x snap-mandatory scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;" >
                <div class="flex gap-3 px-4 py-4 flex-nowrap" style="width:fit-content;">
                    @foreach ($finitions as $trimName => $minPrice)
                        <div class="relative max-w-[70vw] h-40 bg-white border-2 border-gray-200 rounded-lg w-96 snap-center hover:outline-2 hover:outline-theme flex flex-col items-center">
                            <div class="flex items-center flex-1 p-4 px-6 text-2xl font-semibold leading-7 text-center uppercase">{{ $trimName }}</div>
                            <div class="flex items-center justify-between w-full p-4 border-t border-gray-100">
                                <div class="flex-1 text-xs">Prix à partir de</div>
                                <div class="text-xs"><a href="#versions" class="mr-1 text-base font-extrabold md:text-base">{{ number_format($minPrice, 0, ',', '.') . ' €' }}</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-center max-w-screen-xl gap-4 px-4 mx-auto mt-0">
                <div class="p-2 font-light rounded-full shadow-lg cursor-pointer text-md icon icon-chevron-left hover:opacity-90" @click="back" :class="expanded ? 'text-3xl' : 'bg-white'"></div>
                <div class="p-2 font-light rounded-full shadow-lg cursor-pointer text-md icon icon-chevron-right hover:opacity-90" @click="next" :class="expanded ? 'text-3xl' : 'bg-white'"></div>
            </div>
        </div>
    </div>


    <div class="h-20"></div>


    @foreach ($vehicle['model']['versions'] as $version)
        {{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($specs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
        {{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($version, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
    @endforeach

      {{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($vehicle, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}

</x-layouts.app>
