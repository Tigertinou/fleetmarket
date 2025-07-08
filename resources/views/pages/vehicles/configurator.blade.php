@php
$vehicle = $vehicles['data'][0];
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.search.make', [ 'make' => $vehicle['model']['makeUrlCode'] ]), 'label' => $vehicle['model']['makeName'], 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.detail.model', [ 'make' => $vehicle['model']['makeUrlCode'], 'model' => $vehicle['model']['modelUrlCode'] ]), 'label' => $vehicle['model']['modelName'], 'class' => 'font-semibold text-black'],
    ['label' => 'Configurateur' ]
];
$versionSelected = $vehicle['model']['versions'][0]['versionHistoricalId'] ?? null;

$finitions_detail = collect($vehicle['model']['versions'])
->groupBy('trimName')
->sortBy('price')
->map(function ($versions) {
    return $versions;
});

$motors_detail = collect($vehicle['model']['versions'])
->groupBy('versionName')
->sortBy('price')
->map(function ($versions) {
    return $versions;
});

$finitions = collect($vehicle['model']['versions'])
->sortBy('price')
->groupBy('trimName')
->map(function ($versions) {
    return array(
        'trimCode' => $versions->first()['trimCode'],
        'trimName' => $versions->first()['trimName'],
        'versionHistoricalId' => $versions->first()['versionHistoricalId'],
        'price' => $versions->first()['price'],
        'fuelTypes' => $versions->pluck('fuelType')->unique()->values()->all(),
        );
});

$motors = collect($vehicle['model']['versions'])
->groupBy('versionName')
->map(function ($versions) {
    return array(
        'trimCode' => $versions->first()['trimCode'],
        'trimName' => $versions->first()['trimName'],
        'versionUrlCode' => $versions->first()['versionUrlCode'],
        'versionName' => $versions->first()['versionName'],
        'versionHistoricalId' => $versions->first()['versionHistoricalId'],
        'price' => $versions->first()['priceMsrp'],
        'fuelType' => $versions->first()['fuelType'],
        /* 'engineCode' => $version[0]['engineCode'],
        'engineName' => $version[0]['engineName'] */
        );
});

$finitionSelected = $finitions->first()['trimCode'] ?? null;
$motorSelected = $motors->first()['versionUrlCode'] ?? null;

@endphp

<x-layouts.app :title="'Page'" :$breadcrumb>
    <div id="main" x-data="{
        activeTab : 'models',
        finitionSelected : '{{ $finitionSelected }}',
        motorSelected : '{{ $motorSelected }}',
        versionSelected : {{ $versionSelected }},
        coverImage : '{{ $submodeColors['data']['external'][0]['colorImage']['image800'] ?? '' }}',
        coverLabel : '<b>{{ $vehicle['model']['makeName'] }}</b> {{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}',
        init() {
            this.$el.querySelectorAll('.vcolors-image').forEach( (el) => {
                el.style.backgroundImage = 'url(' + this.coverImage + ')';
            });
            this.$el.querySelectorAll('.vcolors-label').forEach( (el) => {
                el.innerHTML = this.coverLabel;
            });
        },
        selectVersion(versionId) {
            this.versionSelected = versionId;

            {{-- window.selectVersion(versionId); --}}
        },
    }">
        <div class="sticky top-0 z-30 bg-white">
            <div class="md:hidden p-4 pb-0">
                <div class="relative flex flex-col items-center w-full pb-2 overflow-hidden border-gray-200 justify-items-stretch border-1 rounded-xl">
                    {{-- <img src="{{ $make['logo'] }}" class="absolute w-10 md:w-24 md:order-1 right-4 top-4" alt="{{ $vehicle['model']['makeName'] }} logo"> --}}
                    <div class="self-center w-full max-w-lg bg-contain vcolors-image aspect-16/9 bg-center bg-no-repeat"></div>
                    <div class="absolute text-xs font-normal vcolors-label top-3 left-4 right-4 text-center"></div>
                    {{-- <img src="{{ $submodeColors['data']['external'][0]['colorImage']['image800'] }}" class="object-cover w-full h-full"> --}}
                </div>
            </div>
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-screen-xl mx-auto overflow-auto scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;">
                    <div class="flex max-w-full gap-6 px-6 text-xs font-semibold md:px-4 flex-nowrap">
                        <div class="pt-6 pb-3 tab-item" :class="activeTab=='models' ? 'border-b-4 border-black' : ''">MODÈLE</div>
                        <div class="pt-6 pb-3 tab-item">FINITIONS</div>
                        <div class="pt-6 pb-3 tab-item">MOTEURS</div>
                        <div class="pt-6 pb-3 tab-item">EXTÉRIEUR</div>
                        <div class="pt-6 pb-3 tab-item">INTÉRIEUR</div>
                        <div class="pt-6 pb-3 tab-item">JANTES</div>
                        <div class="pt-6 pb-3 tab-item">PACKS</div>
                        <div class="pt-6 pb-3 tab-item">OPTIONS</div>
                        <div class="pt-6 pb-3 tab-item">ACCESSOIRES</div>
                        <div class="pt-6 pb-3 tab-item">RÉCAPITULATIF</div>
                        <div>&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col max-w-screen-xl gap-4 px-4 mx-auto md:flex-row">
            {{-- *************************************** LEFT *************************************** --}}
            <div class="flex-1 py-6">

                <div class="flex flex-row flex-wrap w-full mb-4 md:items-center md:gap-4 justify-beetween md:w-auto">
                    <div class="flex-1 order-1">
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
                    <div class="flex flex-col items-end justify-end order-3 w-full py-2 md:order-2 md:w-auto">
                        <a href="" class="text-xs underline">Comparer des modèles<i class="ml-2 text-xl icon icon-eye"></i></a>
                        <a href="" class="text-xs underline">Sauvegarder la configuration<i class="ml-2 text-xl icon icon-bookmark"></i></a>
                    </div>
                    <img src="{{ $make['logo'] }}" class="self-start order-2 w-20 md:w-24 md:order-3" alt="{{ $vehicle['model']['makeName'] }} logo">
                </div>

                <div class="hidden md:block">
                    <div class="relative flex flex-col items-center w-full p-4 pb-6 overflow-hidden border-gray-200 justify-items-stretch border-1 rounded-xl">
                        {{-- <img src="{{ $make['logo'] }}" class="absolute w-10 md:w-24 md:order-1 right-4 top-4" alt="{{ $vehicle['model']['makeName'] }} logo"> --}}
                        <div class="self-center w-full max-w-lg bg-contain vcolors-image aspect-video"></div>
                        <div class="absolute text-xs font-normal vcolors-label top-4 left-4"></div>
                        {{-- <img src="{{ $submodeColors['data']['external'][0]['colorImage']['image800'] }}" class="object-cover w-full h-full"> --}}
                    </div>
                </div>

                <div class="flex w-full gap-4 my-4 flex-col lg:flex-row">
                    <div class="flex-1">
                        <h2 class="text-2xl mb-4 font-normal">Calcul de prix</h2>
                        <x-utils.box color="gray" class="w-full text-sm">
                            <b class="font-bold">Prix total</b>
                            <div class="flex">
                                <div class="flex-1">Prix de base</div>
                                <div class="self-end">12 890 €</div>
                            </div>
                            <div class="flex">
                                <div class="flex-1">Total des options configurées</div>
                                <div class="self-end">1 068 €</div>
                            </div>
                            <div class="flex">
                                <div class="flex-1">Frais de livraison incluant la contribution environnementale pour le recyclage 
                                    de la voiture</div>
                                <div class="self-end">950 €</div>
                            </div>
                            <div class="flex mt-2">
                                <div class="flex-1 font-bold">Prix total</div>
                                <div class="self-end">14 950 €</div>
                            </div>
                        </x-utils.box>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl mb-4 font-normal">Configuration</h2>
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
                        <div>
                            <x-utils.label label="ESSENCE" />
                            <x-utils.label label="MANUELLE" />
                            <x-utils.label label="AV" />
                            <ul class="flex flex-col cursor-default gap-y-2 gap-x-1 specs-list text-xs my-4">
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
                </div>

                <div class="text-xs text-gray-400 my-4">
                    * Les prix indiqués sur fleet market ne sont pas exempts de possibles erreurs et ce malgré nos contrôles attentifs et minutieux. Les éventuelles imprécisions peuvent concerner la date et/ou la durée des promotions. DriveK s’engage à mettre à jour toutes informations signalées dès que possible et ne pourra pas être tenu pour responsable d’erreurs éventuelles.

                    ** Les valeurs de consommation de carburant et d'émissions de CO₂ indiquées sont conformes à la procédure d’essai WLTP sur la base de laquelle sont réceptionnés les véhicules neufs depuis le 1er septembre 2018. Cette procédure WLTP remplace le cycle européen de conduite (NEDC), qui était la procédure d'essai utilisée précédemment. Les conditions d'essai étant plus réalistes, la consommation de carburant et les émissions de CO₂ mesurées selon la procédure WLTP sont, dans de nombreux cas, plus élevées que celles mesurées selon la procédure NEDC. Les valeurs de consommation de carburant et d'émissions de CO₂ peuvent varier en fonction des conditions réelles d’utilisation et de différents facteurs tels que : les équipements spécifiques, les options et les types de pneumatiques. Veillez à vous rapprocher de votre point de vente pour plus de renseignements.

                    AutoXY S.p.A. s'engage à maintenir et à mettre à jour régulièrement tout le contenu de ce site web. Malgré tout, AutoXY S.p.A. ne garantit pas l'exactitude des informations contenues dans le site, qui peuvent devenir obsolètes par erreur ou par oubli. AutoXY S.p.A. ne pourra pas être tenu responsable des éventuelles erreurs ou lacunes, ou des dommages directs, indirects, conséquences ou de n'importe quel autre type de dommages en lien avec l'utilisation du présent site web ou des fonctions contenues dans celui-ci.
                </div>

            </div>
            {{-- *************************************** RIGHT *************************************** --}}
            <div class="py-6 border-gray-200 md:px-4 md:border-l md:w-md md:relative md:h-auto md:z-5">
                <h2 class="text-2xl font-normal">Configurer</h2>
                {{-- ************* FINITIONS ************* --}}
                <h3 class="text-lg font-semibold">Finitions</h3>
                <div class="flex flex-col gap-3 mt-4 select-none" x-data="{
                    change(target){
                        $el.querySelectorAll('[type=radio]').forEach( (el) => {
                            const data = Alpine.$data(el).active = (el==target);
                        });
                    },
                    select(target){
                        const radio = target.closest('.box').querySelector('[type=radio]');
                        if(radio!=null){
                            radio.click();
                            finitionSelected = radio.value;
                        }
                    },
                    init () {
                        $el.querySelectorAll('[type=radio]').forEach( (el) => {
                            if(el.value == finitionSelected){
                                this.select(el);
                            }
                        });
                    }}">
                    @foreach ($finitions as $finition)
                        <x-utils.box x-data="{active : ( finitionSelected == '{{ $finition['trimCode'] }}' )}" x-bind:class="active ? 'border-theme' : 'border-gray-200'" color="bordered" class="flex-1 w-full cursor-pointer hover:outline-2 hover:border-white hover:outline-theme">
                            <div class="flex gap-3" @click="select($event.target)">
                                <x-forms.elements.radio name="inp_finition" value="{{ $finition['trimCode'] }}" @change="change($event.target)" size="md" class="pt-0.5 -ml-2 "/>
                                <div class="flex w-full gap-1 leading-5 justify-stretch">
                                    <div class="flex-1">
                                        <b class="font-semibold uppercase">{{ $finition['trimName'] }}</b>
                                        <br><small><b class="uppercase">{{ implode(' / ',$finition['fuelTypes'])}}</b></small>
                                    </div>
                                    <div class="justify-end text-right">
                                        <span class="flex-1 text-xs whitespace-nowrap">à partir de</span><br>
                                        <span class="text-xs whitespace-nowrap"><span class="text-base font-extrabold md:text-base">{{ number_format($finition['price'], 0, ',', '.') . ' €' }}</span></span>
                                    </div>
                                </div>
                            </div>
                        </x-utils.box>
                    @endforeach
                </div>

                {{-- ************* MOTEURS ************* --}}
                <h3 class="mt-4 text-lg font-semibold">Moteurs</h3>
                <div class="flex flex-col gap-3 mt-4 select-none" x-data="{
                    change(target){
                        $el.querySelectorAll('[type=radio]').forEach( (el) => {
                            const data = Alpine.$data(el).active = (el==target);
                        });
                    },
                    select(target){
                        const radio = target.closest('.box').querySelector('[type=radio]');
                        if(radio!=null){
                            radio.click();
                        }
                    },
                    init () {
                        $el.querySelectorAll('[type=radio]').forEach( (el) => {
                            if(el.value == motorSelected){
                                this.select(el);
                            }
                        });
                    }}">
                    @foreach ($motors as $motor)
                        <x-utils.box x-data="{active : ( motorSelected == '{{ $motor['versionUrlCode'] }}' )}" x-show="finitionSelected == '{{ $motor['trimCode'] }}'" x-bind:class="active ? 'border-theme' : 'border-gray-200'" color="bordered" class="flex-1 w-full cursor-pointer hover:outline-2 hover:border-white hover:outline-theme">
                            <div class="flex gap-3" @click="select($event.target)">
                                <x-forms.elements.radio name="inp_motor" value="{{ $motor['versionUrlCode'] }}" @change="change($event.target)" size="md" class="pt-0.5 -ml-2 "/>
                                <div class="flex w-full gap-1 leading-5 justify-stretch">
                                    <div class="flex-1">
                                        <b class="font-semibold">{{ $motor['versionName'] }}</b>
                                        <br><small><b class="uppercase">{{ $motor['fuelType']}}</b></small>
                                    </div>
                                    <div class="justify-end text-right">
                                        <span class="flex-1 text-xs whitespace-nowrap">à partir de</span><br>
                                        <span class="text-xs whitespace-nowrap"><span class="text-base font-extrabold md:text-base">{{ number_format($motor['price'], 0, ',', '.') . ' €' }}</span></span>
                                    </div>
                                </div>
                            </div>
                        </x-utils.box>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="sticky bottom-0 z-30 bg-white border-t border-gray-200">
            <div class="flex flex-col max-w-screen-xl mx-auto md:flex-row items-center md:px-4">
                <div class="flex-1 md:py-4 py-2 leading-4 w-full px-4 md:px-0 text-xs md:text-base">
                    <span class="font-bold">{{ $vehicle['model']['makeName'] }}</span>
                    <span class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</span><br>
                    <small>35 TFSI 150 MHEV S Tronic Design</small>
                </div>
                <div class="py-3 md:w-md md:relative flex items-center gap-4 bg-gray-100 px-4 w-full">
                    <div class="flex-1 leading-4">
                        <span class="text-xs font-normal">à partir de</span><br>
                        <span class="text-2xl font-bold">40.000 €</span><small> TTC*</small>
                    </div>
                    <div class="w-1/2">
                        <x-utils.button label="Continuer" r-icon="icon-chevron-right" class="w-full max-w-sm"></x-utils.button>
                    </div>
                </div>
            </div>
            {{--
            <div class="max-w-screen-xl px-4 py-6 mx-auto text-sm text-gray-500">
                <p class="text-xs">* Prix TTC, hors options et accessoires. Les prix peuvent varier en fonction des options sélectionnées et des promotions en cours.</p>
                <p class="text-xs">Les informations présentées sont à titre indicatif et peuvent être modifiées sans préavis.</p>
            </div>--}}
        </div>

    </div>
</x-layouts.app>
<script>
window.selectVersion = function (versionId) {
    window.api.motork.getVersionDetails(versionId).then(function (version) {
        console.log(version.versionId);
        // document.querySelector('.vcolors-image').style.backgroundImage = 'url(' + submodeColors.data.external[0].colorImage.image800 + ')';
        // document.querySelector('.vcolors-label').innerHTML = submodeColors.data.external[0].colorGroup + ' : ' + submodeColors.data.external[0].colorDescription;
    }).catch(function (error) {
        console.error('Error fetching version:', error);
    });

    /* window.api.motork.getSubmodeColors({ versionId: versionId }).then(function (submodeColors) {
        console.log(submodeColors);

    }); */
};
document.addEventListener('DOMContentLoaded', function () {
    Alpine.$data(document.getElementById('header')).sticky = false;



    
    window.selectVersion({{ $versionSelected }});
    console.log(@json($vehicle['model']['versions']));
    console.log(@json($motors));
    console.log(@json($finitions));
    console.log(@json($finitions_detail));

});
</script>


{{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($submodeColors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}

{{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($vehicle, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
