@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.search.make', [ 'make' => $vehicle['model']['makeUrlCode'] ]), 'label' => $vehicle['model']['makeName'], 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.detail.model', [ 'make' => $vehicle['model']['makeUrlCode'], 'model' => $vehicle['model']['modelUrlCode'] ]), 'label' => $vehicle['model']['modelName'], 'class' => 'font-semibold text-black'],
    ['label' => 'Configurateur' ]
];

$finitionSelected = $finitions->first()['trimCode'] ?? null;
$motorSelected = $motors->first()['versionUrlCode'] ?? null;
$versionHistoricalId = $motors->first()['versionHistoricalId'] ?? null;
@endphp

<x-layouts.app :title="'Page'" :$breadcrumb>
    <div id="main" x-data="{
        onStickyCover : false,
        activeTab : 'MODEL',
        coverImage : '{{ $submodelColors['data']['external'][0]['colorImage']['image800'] ?? '' }}',
        coverLabel : '<b>{{ $vehicle['model']['makeName'] }}</b> {{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}',
        versionHistoricalId : {{ $versionHistoricalId }},
        finitionSelected : '{{ $finitionSelected }}',
        motorSelected : '{{ $motorSelected }}',
        coverColorLabel : null,
        colorExternalSelected : null,
        colorInteriorSelected : null,
        equipmentsSelected : [],
        version : null,
        total : {
            base: 0,
            options: 0,
            shipping: 0,
            total: 0
        },
        init() {
            this.$el.querySelectorAll('.cover-image').forEach( (el) => {
                el.style.backgroundImage = 'url(' + this.coverImage + ')';
            });
            this.$el.querySelectorAll('.cover-label').forEach( (el) => {
                el.innerHTML = this.coverLabel;
            });
        },
        selectVersion(versionId) {
            this.versionHistoricalId = versionId;

            {{-- window.selectVersion(versionId); --}}
        },
    }">
        <div class="sticky top-0 z-30 bg-white">

            <div class="p-4 pb-0 md:hidden" data-move-mobile="cover-mobile">
                {{-- ************* COVER - MOBILE ************* --}}
            </div>

            {{-- ************* TABS ************* --}}
            @include('partials.vehicles.configurator.tabs')

        </div>

        <div class="flex flex-col max-w-screen-xl gap-4 px-4 mx-auto md:flex-row">
            {{-- *************************************** LEFT *************************************** --}}
            <div class="flex-1 pt-6 border-b border-gray-200 md:pb-6 md:border-b-0">

                <div x-intersect:leave="onStickyCover=true" x-intersect:enter="onStickyCover=false" ></div>

                <div data-enter-tab="MODEL"></div>

                <div class="flex flex-row flex-wrap w-full mb-4 md:items-center md:gap-4 justify-beetween md:w-auto">
                    <div class="flex-1 order-1">
                        <h1 class="flex flex-wrap gap-x-2 h1" style="margin:0;">
                            <span>{{ $vehicle['model']['makeName'] }}</span>
                            <span><b class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</b></span>
                        </h1>
                        <p>
                            @if(isset($vehicle['summary']['numVersions']))
                                <span class="text-xs font-light underline cursor-pointer" @click="document.querySelector(`[data-tab='FINITIONS']`).click()">Disponible en {{ $vehicle['summary']['numVersions'] }} versions</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-col items-end justify-end order-3 w-full py-2 md:order-2 md:w-auto">
                        <a href="" class="text-xs underline">Comparer des modèles<i class="ml-2 text-xl icon icon-eye"></i></a>
                        <a href="" class="text-xs underline">Sauvegarder la configuration<i class="ml-2 text-xl icon icon-bookmark"></i></a>
                    </div>
                    <img src="{{ $make['logo'] }}" class="self-start order-2 w-20 md:w-24 md:order-3" alt="{{ $vehicle['model']['makeName'] }} logo">
                </div>

                <div class="md:sticky top-24">
                    <div class="hidden md:block" data-move-desktop="cover-mobile">
                        {{-- ************* COVER ************* --}}
                        @include('partials.vehicles.configurator.cover')
                    </div>

                    <div data-move-desktop="resume">

                        <div data-enter-tab="RESUME"></div>
                        <div class="flex flex-col w-full gap-4 md:my-4 lg:flex-row">
                            <div class="order-1 pt-6 mt-6 -mb-2 leading-none border-t border-gray-200 md:hidden">
                                <h2 class="text-2xl font-bold">Récapitulatif</h2>
                            </div>
                            <div class="flex-1 order-3 md:order-1">
                                {{-- ************* RESUME - PRICE ************* --}}
                                <h2 class="mb-4 text-2xl font-normal">Calcul de prix</h2>
                                @include('partials.vehicles.configurator.resume-price')

                            </div>
                            <div class="flex-1 order-2 md:order-2">
                                {{-- ************* RESUME - SPECS ************* --}}
                                <h2 class="mb-4 text-2xl font-normal">Configuration</h2>
                                @include('partials.vehicles.configurator.resume-specs')

                            </div>
                        </div>

                        {{-- ************* MENTIONS ************* --}}
                        @include('partials.vehicles.configurator.mentions')

                    </div>
                </div>

            </div>
            {{-- *************************************** RIGHT *************************************** --}}
            <div class="border-gray-200 md:py-6 md:px-4 md:border-l md:w-md md:relative md:h-auto md:z-5">

                <h2 class="text-2xl md:font-normal">Configurer</h2>

                {{-- ************* FINITIONS ************* --}}
                <div data-enter-tab="FINITIONS"></div>
                <h3 class="text-lg font-semibold" >Finitions</h3>
                @include('partials.vehicles.configurator.finitions')


                {{-- ************* MOTEURS ************* --}}
                <div data-enter-tab="MOTORS"></div>
                <h3 class="mt-4 text-lg font-semibold">Moteurs</h3>
                @include('partials.vehicles.configurator.motors')

                {{-- ************* COLORS - EXTERIEUR ************* --}}
                <div data-enter-tab="EXTERNAL"></div>
                <h3 class="mt-4 mb-2 text-lg font-semibold">Couleurs extérieur</h3>
                @include('partials.vehicles.configurator.colors-external')

                {{-- ************* COLORS - INTERIEUR ************* --}}
                <div data-enter-tab="INTERIOR"></div>
                <h3 class="mt-4 mb-2 text-lg font-semibold">Couleurs intérieur</h3>
                @include('partials.vehicles.configurator.colors-interior')

                {{-- ************* OPTIONS ************* --}}
                <div data-enter-tab="OPTIONS"></div>
                <h3 class="mt-4 mb-2 text-lg font-semibold">Options</h3>
                @include('partials.vehicles.configurator.options')

            </div>
            <div data-move-mobile="resume">
                {{-- ************* RESUME - MOBILE ************* --}}
            </div>
        </div>

        <div class="sticky bottom-0 z-30 bg-white border-t border-gray-200">
            <div class="flex flex-col items-center max-w-screen-xl mx-auto md:flex-row md:px-4">
                <div class="flex-1 w-full px-4 py-2 text-xs leading-4 md:py-4 md:px-0 md:text-base">
                    <span class="font-bold">{{ $vehicle['model']['makeName'] }}</span>
                    <span class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</span><br>
                    <small x-text="version?.versionName"></small>
                </div>
                <div class="flex items-center w-full gap-4 px-4 py-3 bg-gray-100 md:w-md md:relative">
                    <div class="flex-1 leading-4 cursor-pointer" @click="document.querySelector(`[data-tab='RESUME']`).click()">
                        <span class="text-xs font-normal">à partir de</span><br>
                        <span class="text-2xl font-bold" x-text="total.total.toEuro()">-</span><small> TTC*</small>
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
{{--@dump($submodelColors)--}}

<script>

window.configurator = {
    options: [],
    versions: [],
    colors: [],
    applyTotal: function() {
        const mainData = Alpine.$data(document.getElementById('main'));
        if(mainData?.version == null) {
            return;
        }
        mainData.total.base = mainData.version.price || 0;
        mainData.total.options = 0;
        mainData.total.shipping = 950;
        if(mainData.colorExternalSelected!=null){
            colorExternal = window.configurator.colors.data['external'].filter(function (v) {
                return v.code == mainData.colorExternalSelected;
            })[0];
            if(colorExternal!=null){
                mainData.total.options += parseFloat(colorExternal.msrpPrice);
            }
        }
        if(mainData.colorInteriorSelected!=null){
            colorInterior = window.configurator.colors.data['interior'].filter(function (v) {
                return v.code == mainData.colorInteriorSelected;
            })[0];
            if(colorInterior!=null){
                mainData.total.options += parseFloat(colorInterior.msrpPrice);
            }
        }
        if(mainData.equipmentsSelected && mainData.equipmentsSelected.length > 0) {
            mainData.equipmentsSelected.forEach(function (equipment) {
                if(equipment.msrp > 0) {
                    mainData.total.options += parseFloat(equipment.msrp);
                }
            });
        }
        mainData.total.total = mainData.version.price + mainData.total.options + mainData.total.shipping;
    },
    selectVersion: function(versionId) {
        version = window.configurator.versions.filter(function (v) {
            return v.versionHistoricalId == versionId;
        })[0];
        const mainData = Alpine.$data(document.getElementById('main'));
        mainData.version = version;
        window.configurator.loadEquipments();
        window.configurator.applyTotal();
    },
    loadEquipments: function() {
        const mainData = Alpine.$data(document.getElementById('main'));
        if(mainData?.version == null) {
            return;
        }
        const version = mainData.version;

        document.querySelectorAll('#options-list').forEach(function (el) {
            Alpine.$data(el).options = {};
            window.api.motork.getEquipments(version.versionId).then(function (result) {
                window.configurator.options = result.data;
                Alpine.$data(el).options = window.configurator.options;
                if(mainData.equipmentsSelected.length > 0) {
                    /* mainData.equipmentsSelected.forEach((equipment) => {
                        const eq = window.configurator.options.find(e => e.idEquipment == equipment.idEquipment);
                        if(eq) {
                            eq.selected = true;
                        }
                    }); */
                } else {
                    mainData.equipmentsSelected = window.configurator.options.filter(e => e.type == 'STANDARD');
                }
                /* if(version.equipments && version.equipments.length > 0) {
                    mainData.equipmentsSelected = version.equipments.map(e => e.code);
                } else {
                    mainData.equipmentsSelected = [];
                } */
                console.log('options', window.configurator.options);
            });
        });

    },
    addEquipment: function(equipment) {
        const mainData = Alpine.$data(document.getElementById('main'));
        if(mainData?.version == null) {
            return;
        }
        console.log('addEquipment', equipment.idEquipment, equipment);
        if(!mainData.equipmentsSelected.includes(equipment)) {
            window.api.motork.addEquipment(mainData.version.versionId, equipment.idEquipment, mainData.equipmentsSelected.map(e => e.idEquipment).join(',')).then((result) => {
                console.log('addEquipment', result);
                mainData.equipmentsSelected.push(equipment);
                // window.configurator.loadEquipments();
                window.configurator.applyTotal();
            });
        }
    },
    removeEquipment: function(equipment) {
        const mainData = Alpine.$data(document.getElementById('main'));
        if(mainData?.version == null) {
            return;
        }
        console.log('removeEquipment', equipment.idEquipment, equipment);
        const index = mainData.equipmentsSelected.indexOf(equipment);
        if(index > -1) {
            window.api.motork.removeEquipment(mainData.version.versionId, equipment.idEquipment, mainData.equipmentsSelected.map(e => e.idEquipment).join(',')).then((result)  => {
                console.log('removeEquipment', result);
                mainData.equipmentsSelected.splice(mainData.equipmentsSelected.indexOf(equipment), 1);
                // window.configurator.loadEquipments();
                window.configurator.applyTotal();
            });
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {

    window.configurator.versions = @json($vehicle['model']['versions']);
    window.configurator.colors = @json($submodelColors);
    Alpine.$data(document.getElementById('header')).sticky = false;
    window.configurator.selectVersion({{ $versionHistoricalId }});

    console.log(@json($vehicle));
    console.log('submodelColors',@json($submodelColors));
    /*{{--
    console.log('motors',@json($motors));
    console.log('finitions',@json($finitions));
    console.log('finitions_detail',@json($finitions_detail)); --}}*/

});
</script>
