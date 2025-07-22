@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.search.make', [ 'make' => $vehicle['model']['makeUrlCode'] ]), 'label' => $vehicle['model']['makeName'], 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.detail.model', [ 'make' => $vehicle['model']['makeUrlCode'], 'model' => $vehicle['model']['modelUrlCode'] ]), 'label' => $vehicle['model']['modelName'], 'class' => 'font-semibold text-black'],
    ['label' => 'Configurateur' ]
];

$finitionSelected = $finitions->first()['trimCode'] ?? null;
$motorSelected = $motors->first()['versionUrlCode'] ?? null;
$versionHistoricalId = $versionHistoricalId ?? $motors->first()['versionHistoricalId'] ?? null;
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
        optionsModalOpen : false,
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
        if(window.xMainData?.version == null) {
            return;
        }
        window.xMainData.total.base = window.xMainData.version.price || 0;
        window.xMainData.total.options = 0;
        window.xMainData.total.shipping = 950;
        if(window.xMainData.colorExternalSelected!=null){
            colorExternal = window.configurator.colors.data['external'].filter(function (v) {
                return v.code == window.xMainData.colorExternalSelected;
            })[0];
            if(colorExternal!=null){
                window.xMainData.total.options += parseFloat(colorExternal.msrpPrice);
            }
        }
        if(window.xMainData.colorInteriorSelected!=null){
            colorInterior = window.configurator.colors.data['interior'].filter(function (v) {
                return v.code == window.xMainData.colorInteriorSelected;
            })[0];
            if(colorInterior!=null){
                window.xMainData.total.options += parseFloat(colorInterior.msrpPrice);
            }
        }
        if(window.xMainData.equipmentsSelected && window.xMainData.equipmentsSelected.length > 0) {
            window.xMainData.equipmentsSelected.forEach(function (equipment) {
                if(equipment.msrp > 0) {
                    window.xMainData.total.options += parseFloat(equipment.msrp);
                }
            });
        }
        window.xMainData.total.total = window.xMainData.version.price + window.xMainData.total.options + window.xMainData.total.shipping;
    },
    selectVersion: function(versionId) {
        version = window.configurator.versions.filter(function (v) {
            return v.versionHistoricalId == versionId;
        })[0];
        window.xMainData.version = version;
        window.configurator.loadEquipments();
        window.configurator.applyTotal();
    },
    loadColors: async function() {
        if(window.xMainData?.version == null) {
            return;
        }
        const version = window.xMainData.version;
        var result = await window.api.motork.getColors(version.versionId);
        window.configurator.colors.all = result.data;
    },
    loadEquipments: async function() {
        if(window.xMainData?.version == null) {
            return;
        }
        const version = window.xMainData.version;

        await window.configurator.loadColors();
        var excludedEquipments = [];
        for(var type in window.configurator.colors.all) {
            for(var a of window.configurator.colors.all[type]) {
                if(a?.equipment?.id!=null){
                    excludedEquipments.push(a.equipment.id.toString());
                }
            }
        }

        document.querySelectorAll('#options-list').forEach(function (el) {
            Alpine.$data(el).options = {};
            window.api.motork.getEquipments(version.versionId).then(function (result) {
                window.configurator.options = result.data;
                for(var category in window.configurator.options){
                    for(var subcategory in window.configurator.options[category]){
                        window.configurator.options[category][subcategory] = window.configurator.options[category][subcategory].filter(function (v) {
                            return excludedEquipments.includes(v.idEquipment.toString()) ? false : true;
                        });
                        if(window.configurator.options[category][subcategory].length == 0) {
                            delete window.configurator.options[category][subcategory];
                        }
                    }
                };

                Alpine.$data(el).options = window.configurator.options;
                if(window.xMainData.equipmentsSelected.length > 0) {
                    /* window.xMainData.equipmentsSelected.forEach((equipment) => {
                        const eq = window.configurator.options.find(e => e.idEquipment == equipment.idEquipment);
                        if(eq) {
                            eq.selected = true;
                        }
                    }); */
                } else {
                    /* window.xMainData.equipmentsSelected = window.configurator.options.filter(e => e.type == 'STANDARD'); */
                }
                /* if(version.equipments && version.equipments.length > 0) {
                    window.xMainData.equipmentsSelected = version.equipments.map(e => e.code);
                } else {
                    window.xMainData.equipmentsSelected = [];
                } */
                // console.log('options', window.configurator.options);
            });
        });

    },
    retrieveEquipment: function(id){
        if(id!=null && id!='')
        for(var category in window.configurator.options){
            for(var subcategory in window.configurator.options[category]){
                for(var e of window.configurator.options[category][subcategory]){
                    if(e.idEquipment==id){ return e; }
                }
            }
        };
        return {};
    },
    addEquipment: async function(equipment) {
        if(window.xMainData?.version == null) {
            return;
        }
        if(typeof equipment != 'object'){
            equipment = window.configurator.retrieveEquipment(equipment);
        }
        if(!window.xMainData.equipmentsSelected.includes(equipment)) {
            var config = window.xMainData.equipmentsSelected.map(e => e.idEquipment);
            /* config.push(window.xMainData.colorExternalSelected); */
            /* config.push(window.xMainData.colorExternalSelected); */
            /* window.xMainData.colorExternalSelected */
            const result = await window.api.motork.addEquipment(window.xMainData.version.versionId, equipment.idEquipment, config.join(','));
            if(result?.data?.status == 'OK'){
                window.xMainData.equipmentsSelected.push(equipment);
                window.configurator.applyTotal();
            } else {
                document.querySelectorAll('#id-equipments-' + equipment.idEquipment).forEach((el) => {
                    el.checked = false;
                    Alpine.$data(el.closest('[x-data]')).checked = false;
                });
                const modal = document.querySelector('#options-modal');
                if(modal) {
                    const j = result?.data || {};
                    adjustToAdd = [];
                    adjustToRemove = [];

                    modal.querySelector('[data-area="title"]').innerHTML = `Assistant`;
                    var content = ``;
                    content += `<div class="text-sm">L'équipement sélectionné nécessite quelques modifications.</div>`;
                    content += `<div class="mt-4 mb-2 font-semibold">Vous souhaitez ajouter</div>`;
                    for(var dtos of j.equipmentDTOs){
                        if(dtos.id==result.idEquipment){
                            content += `
                            <div class="flex gap-2">
                                <span class="mr-2 align-middle"><i class="inline-block icon icon-download"></i></span>
                                <span class="flex-1 text-sm">${dtos.description}</span>
                                <span class="text-sm font-bold">${dtos.price.toEuro()}</span>
                            </div>`;
                        }
                    }
                    content += `<div class="mt-4 mb-2 font-semibold">Ajustement requis</div>`;
                    for(var alternative in j.alternatives.decision) {
                        switch (alternative) {
                            case 'REMOVE_ALL':
                                console.log('REMOVE_ALL');
                                console.log(j);
                                console.log(j.alternatives.decision[alternative]);
                                content += `<div class="mb-2 text-sm">Retirer ce(s) équipement(s) ?</div>`;
                                for(var adjustment of j.alternatives.decision[alternative]) {
                                    for(var value of adjustment.values) {
                                        content += `
                                        <div class="flex gap-2">
                                            <span class="mr-2 align-middle"><i class="inline-block icon icon-upload"></i></span>
                                            <span class="flex-1 text-sm">${value.description}</span>
                                            <span class="text-sm font-bold">-${value.price.toEuro()}</span>
                                        </div>`;
                                        adjustToRemove.push(value.id);
                                    }
                                }
                            break;
                            case 'REMOVE_ONE_OF':
                                console.log('REMOVE_ONE_OF');
                                console.log(j);
                                console.log(j.alternatives.decision[alternative]);
                                content += `<div class="mb-2 text-sm">Supprimer l'un de ces équipements ?</div>`;
                                for(var adjustment of j.alternatives.decision[alternative]) {
                                    var value = adjustment.value;
                                    content += `
                                    <div class="flex gap-2">
                                        <span class="mr-2 align-middle"><i class="inline-block icon icon-upload"></i></span>
                                        <span class="flex-1 text-sm">${value.description}</span>
                                        <span class="text-sm font-bold">-${value.price.toEuro()}</span>
                                    </div>`;
                                    adjustToRemove.push(value.id);
                                }
                            break;
                            case 'ADD_ALL':
                                console.log('ADD_ALL');
                                console.log(j);
                                console.log(j.alternatives.decision[alternative]);
                                content += `<div class="mb-2 text-sm">Ajouter ce(s) équipement(s) ?</div>`;
                                for(var adjustment of j.alternatives.decision[alternative]) {
                                    for(var value of adjustment.values) {
                                        content += `
                                        <div class="flex gap-2">
                                            <span class="mr-2 align-middle"><i class="inline-block icon icon-upload"></i></span>
                                            <span class="flex-1 text-sm">${value.description}</span>
                                            <span class="text-sm font-bold">-${value.price.toEuro()}</span>
                                        </div>`;
                                        adjustToAdd.push(value.id);
                                    }
                                }
                            break;
                            case 'ADD_ONE_OF':
                                console.log('ADD_ONE_OF');
                                console.log(j);
                                console.log(j.alternatives.decision[alternative]);
                                content += `<div class="mb-2 text-sm">Ajouter un de ces équipements ?</div>`;
                                for(var adjustment of j.alternatives.decision[alternative]) {
                                    var value = adjustment.value;
                                    content += `
                                    <div class="flex gap-2">
                                        <span class="mr-2 align-middle"><i class="inline-block icon icon-upload"></i></span>
                                        <span class="flex-1 text-sm">${value.description}</span>
                                        <span class="text-sm font-bold">-${value.price.toEuro()}</span>
                                    </div>`;
                                    adjustToAdd.push(value.id);
                                }
                            break;
                        }
                    }

                    adjustToAdd.push(result.idEquipment);

                    window.configurator.acceptAlternative = async function(){
                        await adjustToRemove.forEach(async (id) => {
                            document.querySelectorAll('#id-equipments-' + id).forEach((el) => {
                                el.checked = false;
                                Alpine.$data(el.closest('[x-data]')).checked = false;
                            });
                            await window.configurator.removeEquipment(id);
                        });
                        await adjustToAdd.forEach(async (id) => {
                            document.querySelectorAll('#id-equipments-' + id).forEach((el) => {
                                el.checked = true;
                                Alpine.$data(el.closest('[x-data]')).checked = true;
                            });
                            await window.configurator.addEquipment(id);
                        });
                        window.xMainData.optionsModalOpen = false;
                    }

                    window.configurator.rejectAlternative = async function(){
                        await document.querySelectorAll('#id-equipments-' + equipment.idEquipment).forEach((el) => {
                            el.checked = false;
                            Alpine.$data(el.closest('[x-data]')).checked = false;
                        });
                        window.configurator.removeEquipment(equipment.idEquipment);
                        window.xMainData.optionsModalOpen = false;
                    }

                    content += `<div class="flex mt-4">
                        <div><a href="javascript:void(0);" class="inline-block w-full max-w-sm px-6 py-3 text-sm font-normal text-center transition-all duration-200 ease-in-out bg-gray-200 rounded-full hover:opacity-90" onclick="window.configurator.rejectAlternative()">
                            <span class="flex items-center justify-center h-full">
                                <span class="mr-2 -ml-3 align-middle"><i class="inline-block icon icon-ban"></i></span>
                                <span>Annuler</span>
                            </span>
                        </a></div>
                        <div class="flex-1"></div>
                        <div><a href="javascript:void(0);" class="inline-block w-full max-w-sm px-6 py-3 text-sm text-center text-white transition-all duration-200 ease-in-out rounded-full hover:opacity-90 bg-theme" onclick="window.configurator.acceptAlternative()">
                            <span class="flex items-center justify-center h-full">
                                <span class="mr-2 -ml-3 align-middle"><i class="inline-block icon icon-check-circle"></i></span>
                                <span>Accepter</span>
                            </span>
                        </a></div>
                        </div>`;
                    window.xMainData.optionsModalOpen = true;
                    modal.querySelector('[data-area="content"]').innerHTML = content;
                }
            }
        }
    },
    removeEquipment: async function(equipment) {
        if(window.xMainData?.version == null) {
            return;
        }
        if(typeof equipment != 'object'){
            equipment = window.configurator.retrieveEquipment(equipment);
        }
        const index = window.xMainData.equipmentsSelected.indexOf(equipment);
        if(index > -1) {
            window.xMainData.equipmentsSelected.splice(window.xMainData.equipmentsSelected.indexOf(equipment), 1);
            var config = window.xMainData.equipmentsSelected.map(e => e.idEquipment);
            config.push(equipment.idEquipment);
            const result = await window.api.motork.removeEquipment(window.xMainData.version.versionId, equipment.idEquipment, config.join(','));
            window.configurator.applyTotal();
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {
    window.xMainData = document.querySelector('#main')._x_dataStack[0];
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
