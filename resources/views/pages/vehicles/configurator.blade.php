@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.search.make', [ 'make' => $vehicle['model']['makeUrlCode'] ]), 'label' => $vehicle['model']['makeName'], 'class' => 'font-semibold text-black'],
    ['url' => localized_route('pages.vehicles.detail.model', [ 'make' => $vehicle['model']['makeUrlCode'], 'model' => $vehicle['model']['modelUrlCode'] ]), 'label' => $vehicle['model']['modelName'], 'class' => 'font-semibold text-black'],
    ['label' => __tl('Configurateur') ]
];

$finitionSelected = $finitionSelected ?? $finitions->first()['trimCode'] ?? null;
$motorSelected = $motorSelected ?? $motors->first()['versionUrlCode'] ?? null;
$versionHistoricalId = $versionHistoricalId ?? $motors->first()['versionHistoricalId'] ?? null;
@endphp

<x-layouts.app :title="'Page'" :$breadcrumb>
    <div id="main" x-data="{
        onStickyCover : false,
        optionsModalOpen : false,
        contactModalOpen : false,
        activeTab : 'MODEL',
        coverImage : '{{ $submodelColors['data']['external'][0]['colorImage']['image800'] ?? '' }}',
        coverLabel : '<b>{{ $vehicle['model']['makeName'] }}</b> {{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}',
        makeSelected : '{{ $vehicle['model']['makeName'] }}',
        modelSelected : '{{ $vehicle['model']['modelName'] }}',
        versionHistoricalId : ({{ $versionHistoricalId }}).toString(),
        version : null,
        finitionSelected : '{{ $finitionSelected }}',
        motorSelected : '{{ $motorSelected }}',
        coverColorLabel : null,
        colorExternalValue : null,
        colorInteriorValue : null,
        colorExternalSelected : null,
        colorInteriorSelected : null,
        equipmentsSelected : [],
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
                                <span class="text-xs font-light underline cursor-pointer" @click="document.querySelector(`[data-tab='FINITIONS']`).click()">
                                    {{ __tl('Disponible en :count version(s)',[ 'count' => $vehicle['summary']['numVersions']]) }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-col items-end justify-end order-3 w-full py-2 md:order-2 md:w-auto">
                        <a href="javascript:void(0);" onclick="window.unavailable()" class="text-xs underline">{{ __tl('Comparer des modèles') }}<i class="ml-2 text-xl icon icon-eye"></i></a>
                        <a href="javascript:void(0);" onclick="window.unavailable()" class="text-xs underline">{{ __tl('Sauvegarder la configuration') }}<i class="ml-2 text-xl icon icon-bookmark"></i></a>
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
                                <h2 class="text-2xl font-bold">{{ __tl('Récapitulatif') }}</h2>
                            </div>
                            <div class="flex-1 order-3 md:order-1">
                                {{-- ************* RESUME - PRICE ************* --}}
                                <h2 class="mb-4 text-2xl font-normal">{{ __tl('Calcul de prix') }}</h2>
                                @include('partials.vehicles.configurator.resume-price')

                            </div>
                            <div class="flex-1 order-2 md:order-2">
                                {{-- ************* RESUME - SPECS ************* --}}
                                <h2 class="mb-4 text-2xl font-normal">{{ __tl('Configuration') }}</h2>
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

                <h2 class="text-2xl md:font-normal">{{ __tl('Configurer') }}</h2>

                {{-- ************* FINITIONS ************* --}}
                <div data-enter-tab="FINITIONS"></div>
                <h3 class="text-lg font-semibold" >{{ __tl('Finitions') }}</h3>
                @include('partials.vehicles.configurator.finitions')


                {{-- ************* MOTEURS ************* --}}
                <div data-enter-tab="MOTORS"></div>
                <h3 class="mt-4 text-lg font-semibold">{{ __tl('Moteurs') }}</h3>
                @include('partials.vehicles.configurator.motors')

                {{-- ************* COLORS - EXTERIEUR ************* --}}
                <div data-enter-tab="EXTERNAL"></div>
                <h3 class="mt-4 mb-2 text-lg font-semibold">{{ __tl('Couleurs extérieur') }}</h3>
                @include('partials.vehicles.configurator.colors-external')

                {{-- ************* COLORS - INTERIEUR ************* --}}
                <div data-enter-tab="INTERIOR"></div>
                <h3 class="mt-4 mb-2 text-lg font-semibold">{{ __tl('Couleurs intérieur') }}</h3>
                @include('partials.vehicles.configurator.colors-interior')

                {{-- ************* OPTIONS ************* --}}
                <div data-enter-tab="OPTIONS"></div>
                <h3 class="mt-4 mb-2 text-lg font-semibold">{{ __tl('Options') }}</h3>
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
                        <span class="text-xs font-normal">{{ __tl('à partir de') }}</span><br>
                        <span class="text-2xl font-bold" x-text="total.total.toEuro()">-</span><small> {{ __tl('TTC') }}*</small>
                    </div>
                    <div class="w-1/2">
                        <x-utils.button label="{{ __tl('Continuer') }}" r-icon="icon-chevron-right" class="w-full max-w-sm" @click="window.configurator.continue()"></x-utils.button>
                    </div>
                </div>
            </div>
            {{--
            <div class="max-w-screen-xl px-4 py-6 mx-auto text-sm text-gray-500">
                <p class="text-xs">* Prix TTC, hors options et accessoires. Les prix peuvent varier en fonction des options sélectionnées et des promotions en cours.</p>
                <p class="text-xs">Les informations présentées sont à titre indicatif et peuvent être modifiées sans préavis.</p>
            </div>--}}
        </div>

        <x-layouts.modal ref="optionsModal" id="options-modal"></x-layouts.modal>
        <x-layouts.modal ref="contactModal" id="contact-modal"></x-layouts.modal>
    </div>
</x-layouts.app>
{{--@dump($submodelColors)--}}

<script>

window.configurator = {
    continue : async function(){
        const modal = document.querySelector('#contact-modal');
        if(!modal.classList.contains('loaded')) {
            const response = await fetch(`/{{ app()->getLocale() }}/partials/vehicles/contact/form`);
            if (!response.ok) {
                throw new Error(error.message || 'Erreur');
                return;
            }
            modal.querySelector('[data-area="title"]').innerHTML = `Votre demande de devis`;
            modal.querySelector('[data-area="content"]').innerHTML = await response.text();
            modal.classList.add('loaded');
        }
        modal.querySelectorAll('[name="inp_data"]').forEach(function (el) {
            el.value = JSON.stringify({
                make: window.xMainData.makeSelected,
                model: window.xMainData.modelSelected,
                version: window.xMainData.versionHistoricalId,
                finition: window.xMainData.finitionSelected,
                motor: window.xMainData.motorSelected,
                colorExternal: {
                    code: window.xMainData.colorExternalSelected.code,
                    description: window.xMainData.colorExternalSelected.description,
                    price: window.xMainData.colorExternalSelected.msrpPrice || 0
                },
                colorInterior:{
                    code: window.xMainData.colorInteriorSelected.code,
                    description: window.xMainData.colorInteriorSelected.description,
                    price: window.xMainData.colorInteriorSelected.msrpPrice || 0
                },
                equipments: (window.xMainData.equipmentsSelected || []).map(e => {
                    return {
                        idEquipment: e.idEquipment,
                        code: e.code,
                        description: e.description,
                        price: e.msrp || 0
                    };
                }),
            });
            console.log('inp_data', el.value);
        });
        window.xMainData.contactModalOpen = true;
    },
    options: [],
    versions: [],
    colors: [],
    applyTotal: function() {
        if(window.xMainData?.version == null) {
            return;
        }
        window.xMainData.total.base = window.xMainData.version.price || 0;
        window.xMainData.total.options = 0;
        window.xMainData.total.shipping = 0;
        if(window.xMainData.colorExternalValue!=null){
            window.xMainData.colorExternalSelected = window.configurator.colors.data['external'].filter(function (v) {
                return v.code == window.xMainData.colorExternalValue;
            })[0];
            if(window.xMainData.colorExternalSelected!=null){
                window.xMainData.total.options += parseFloat(window.xMainData.colorExternalSelected.msrpPrice);
            }
        }
        if(window.xMainData.colorInteriorValue!=null){
            window.xMainData.colorInteriorSelected = window.configurator.colors.data['interior'].filter(function (v) {
                return v.code == window.xMainData.colorInteriorValue;
            })[0];
            if(window.xMainData.colorInteriorSelected!=null){
                window.xMainData.total.options += parseFloat(window.xMainData.colorInteriorSelected.msrpPrice);
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
        return null;
    },
    addEquipment: async function(equipment) {
        if(window.xMainData?.version == null) {
            return;
        }
        if(typeof equipment != 'object'){
            equipment = window.configurator.retrieveEquipment(equipment);
        }
        if(equipment?.idEquipment == null || equipment.idEquipment == '') {
            console.error('Invalid equipment', equipment);
            return;
        }
        if(!window.xMainData.equipmentsSelected.includes(equipment)) {
            window.xMainData.equipmentsSelected.push(equipment);
            var config = window.xMainData.equipmentsSelected.map(e => e.idEquipment);
            config = config.filter(i => i !== "" && i !== null);
            var result = await window.api.motork.addEquipment(window.xMainData.version.versionId, equipment.idEquipment, config.join(','));
            if(result?.data?.status == 'OK'){
                window.configurator.applyTotal();
            } else {
                window.xMainData.equipmentsSelected.splice(window.xMainData.equipmentsSelected.indexOf(equipment), 1);
                window.configurator.modalAssistant('add',equipment, result.data);
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
            config = config.filter(i => i !== "" && i !== null);
            var result = await window.api.motork.removeEquipment(window.xMainData.version.versionId, equipment.idEquipment, config.join(','));
            if(result?.data?.status == 'OK'){
                document.querySelectorAll('#id-equipments-' + equipment.idEquipment).forEach((el) => {
                    el.checked = false;
                    Alpine.$data(el.closest('[x-data]')).checked = false;
                });
                window.configurator.applyTotal();
            } else {
                window.xMainData.equipmentsSelected.push(equipment);
                window.configurator.modalAssistant('remove',equipment, result.data);
            }
        }
    },
    modalAssistant: function(action, equipment, data) {
        document.querySelectorAll('#id-equipments-' + equipment.idEquipment).forEach((el) => {
            el.checked = false;
            Alpine.$data(el.closest('[x-data]')).checked = false;
        });
        const modal = document.querySelector('#options-modal');
        if(modal) {
            adjustToAdd = [];
            adjustToRemove = [];

            modal.querySelector('[data-area="title"]').innerHTML = `{{ __tl('Assistant') }}`;
            var content = ``;
            content += `<div class="text-sm">{{ __tl('L\'équipement sélectionné nécessite quelques modifications.') }}</div>`;
            if(action == 'remove') {
                content += `<div class="mt-4 mb-2 font-semibold">{{ __tl('Vous souhaitez retirer') }}</div>
                <div class="flex gap-2" title="${equipment.idEquipment}">
                    <span class=text-xl align-middle"><i class="inline-block icon icon-minus-circle -mt-[0.4em]"></i></span>
                    <span class="flex-1 text-sm">${equipment.description}</span>
                    <span class="text-sm font-bold">-${equipment.msrp.toEuro()}</span>
                </div>`;
            } else if (action == 'add') {
                content += `<div class="mt-4 mb-2 font-semibold">{{ __tl('Vous souhaitez ajouter') }}</div>
                <div class="flex gap-2" title="${equipment.idEquipment}">
                    <span class="text-xl align-middle"><i class="inline-block icon icon-plus-circle -mt-[0.4em]"></i></span>
                    <span class="flex-1 text-sm">${equipment.description}</span>
                    <span class="text-sm font-bold">+${equipment.msrp.toEuro()}</span>
                </div>`;
            }
            content += `<div class="mt-4 mb-2 font-semibold">{{ __tl('Ajustement requis') }}</div>`;
            const optionsList = Alpine.$data(document.querySelectorAll('#options-list')[0]).options;
            for(var alternative in data.alternatives.decision) {

                /* CREATE EQUIPMENT IF NOT EXIST */
                data.alternatives.decision[alternative].forEach((adjustment, index) => {
                    if(adjustment.values==null && adjustment.value!=null){
                        adjustment.values = [];
                        adjustment.values.push(adjustment.value);
                    }
                    adjustment.values.forEach((value) => {
                        value.idEquipment = value.idEquipment || value.id;
                        if(value.idEquipment!=null && value.idEquipment!='') {
                            var retrieve_equipment = window.configurator.retrieveEquipment(value.idEquipment);
                            if(!retrieve_equipment){
                                let d = {
                                    idEquipment: value.idEquipment,
                                    basePrice: value.basePrice || value.price || 0,
                                    code: value.code || '',
                                    description: value.description,
                                    manufactorCode: value.manufactorCode || '',
                                    type: 'OPTION',
                                    msrp: value.price || 0
                                };
                                if(optionsList['Extras'] == null) { optionsList['Extras'] = {}; }
                                window.configurator.options['Extras'] = window.configurator.options['Extras'] || {};
                                if(optionsList['Extras']['Options'] == null) {
                                    optionsList['Extras']['Options'] = window.configurator.options['Extras']['Options'];
                                }
                                window.configurator.options['Extras']['Options'] = window.configurator.options['Extras']['Options'] || [];
                                window.configurator.options['Extras']['Options'].push(d);
                            }
                        }
                    });
                });

                switch (alternative) {
                    case 'REMOVE_ALL':
                        content += `<div class="mb-2 text-sm">{!! __tl('<b class="underline">Retirer</b> ce(s) équipement(s) :') !!}</div>`;
                        content += `<div class="flex flex-col gap-2">`;
                        for(var adjustment of data.alternatives.decision[alternative]) {
                            for(var value of adjustment.values) {
                                content += `
                                <div class="flex gap-2" title="${value.id}">
                                    <span class="text-xl align-middle"><i class="inline-block icon icon-minus-circle -mt-[0.4em]"></i></span>
                                    <span class="flex-1 text-sm">${value.description}</span>
                                    <span class="text-sm font-bold">-${value.price.toEuro()}</span>
                                </div>`;
                                adjustToRemove.push(value.id);
                            }
                        }
                        content += `</div>`;
                    break;
                    case 'REMOVE_ONE_OF':
                        content += `<div class="mb-2 text-sm">{!! __tl('<b class="underline">Retirer</b> l\'un de ces équipements :') !!}</div>`;
                        content += `<div class="flex flex-col gap-2">`;
                        data.alternatives.decision[alternative].forEach((adjustment, index) => {
                            var value = adjustment.value;
                            content += `
                            <div class="flex gap-2 order-${value.price}" title="${value.id}">
                                <span class="radio"><input type="radio" id="id-alternative-${value.id}" name="adjustment_remove_alternative" value="${value.id}" ${index==0 ? 'checked' : ''}></span>
                                <span class="text-xl align-middle"><i class="inline-block icon icon-minus-circle -mt-[0.4em]"></i></span>
                                <label class="flex-1 text-sm" for="id-alternative-${value.id}">${value.description}</label>
                                <span class="text-sm font-bold">-${value.price.toEuro()}</span>
                            </div>`;
                        });
                        content += `</div>`;
                    break;
                    case 'ADD_ALL':
                        content += `<div class="mb-2 text-sm">{!! __tl('<b class="underline">Ajouter</b> ce(s) équipement(s) :') !!}</div>`;
                        content += `<div class="flex flex-col gap-2">`;
                        for(var adjustment of data.alternatives.decision[alternative]) {
                            for(var value of adjustment.values) {
                                content += `
                                <div class="flex gap-2" title="${value.id}">
                                    <span class="text-xl align-middle"><i class="inline-block icon icon-plus-circle -mt-[0.4em]"></i></span>
                                    <span class="flex-1 text-sm">${value.description}</span>
                                    <span class="text-sm font-bold">+${value.price.toEuro()}</span>
                                </div>`;
                                adjustToAdd.push(value.id);
                            }
                        }
                        content += `</div>`;
                    break;
                    case 'ADD_ONE_OF':
                        content += `<div class="mb-2 text-sm">{!! __tl('<b class="underline">Ajouter</b> un de ces équipements :') !!}</div>`;
                        content += `<div class="flex flex-col gap-2">`;
                        data.alternatives.decision[alternative].forEach((adjustment, index) => {
                            var value = adjustment.value;
                            content += `
                            <div class="flex gap-2 order-${value.price}" title="${value.id}">
                                <span class="radio"><input type="radio" id="id-alternative-${value.id}" name="adjustment_add_alternative" value="${value.id}" ${index==0 ? 'checked' : ''}></span>
                                <span class="text-xl align-middle"><i class="inline-block icon icon-plus-circle -mt-[0.4em]"></i></span>
                                <label class="flex-1 text-sm" for="id-alternative-${value.id}">${value.description}</label>
                                <span class="text-sm font-bold">+${value.price.toEuro()}</span>
                            </div>`;
                        });
                        content += `</div>`;
                    break;
                }

            }

            window.configurator.acceptAlternative = async function(){
                modal.querySelectorAll('[name="adjustment_add_alternative"]').forEach((el) => {
                    if(el.checked) {
                        adjustToAdd.push(el.value);
                    }
                });
                if(action == 'remove') {
                    adjustToRemove.push(equipment.idEquipment);
                } else if (action == 'add') {
                    adjustToAdd.push(equipment.idEquipment);
                }
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
                        <span>{{ __tl('Annuler') }}</span>
                    </span>
                </a></div>
                <div class="flex-1"></div>
                <div><a href="javascript:void(0);" class="inline-block w-full max-w-sm px-6 py-3 text-sm text-center text-white transition-all duration-200 ease-in-out rounded-full hover:opacity-90 bg-theme" onclick="window.configurator.acceptAlternative()">
                    <span class="flex items-center justify-center h-full">
                        <span class="mr-2 -ml-3 align-middle"><i class="inline-block icon icon-check-circle"></i></span>
                        <span>{{ __tl('Accepter') }}</span>
                    </span>
                </a></div>
                </div>`;
            window.xMainData.optionsModalOpen = true;
            modal.querySelector('[data-area="content"]').innerHTML = content;
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
/*
window.addEventListener('beforeunload', function (e) {
    if (!hasStartedConfiguration) return;
    console.log(e);
    e.preventDefault();
    e.returnValue = 'Êtes-vous sûr de vouloir stopper la configuration ?';
    return 'Êtes-vous sûr de vouloir stopper la configuration ?';
});*/
</script>
