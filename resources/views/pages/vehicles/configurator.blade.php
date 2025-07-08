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
        coverLabel : '',
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
                <div class="relative flex flex-col items-center w-full p-4 pb-6 overflow-hidden border-gray-200 justify-items-stretch border-1 rounded-xl">
                    {{-- <img src="{{ $make['logo'] }}" class="absolute w-10 md:w-24 md:order-1 right-4 top-4" alt="{{ $vehicle['model']['makeName'] }} logo"> --}}
                    <div class="self-center w-full max-w-lg bg-contain vcolors-image aspect-video"></div>
                    <div class="absolute text-xs font-normal vcolors-label top-4 left-4"></div>
                    {{-- <img src="{{ $submodeColors['data']['external'][0]['colorImage']['image800'] }}" class="object-cover w-full h-full"> --}}
                </div>
            </div>
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-screen-xl mx-auto overflow-auto scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;">
                    <div class="flex max-w-full gap-6 px-6 text-sm font-semibold md:px-4 flex-nowrap">
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
            </div>
            {{-- *************************************** RIGHT *************************************** --}}
            <div class="py-6 border-gray-200 md:px-4 md:border-l md:overflow-visible md:w-lg md:relative md:h-auto md:z-5">
                <h2 class="text-2xl">Configuration</h2>
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

        <div class="sticky bottom-0 z-30 bg-gray-100">
            <div class="flex flex-col max-w-screen-xl mx-auto md:flex-row items-center md:px-4">
                <div class="flex-1 py-4 leading-5 w-full px-4 md:px-0">
                    <span class="font-bold">{{ $vehicle['model']['makeName'] }}</span>
                    <span class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</span><br>
                    <small>35 TFSI 150 MHEV S Tronic Design</small>
                </div>
                <div class="py-3 md:w-lg md:relative flex items-center gap-4 bg-gray-200 px-4 w-full">
                    <div class="flex-1 leading-5">
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

    window.selectVersion({{ $versionSelected }});
    console.log(@json($vehicle['model']['versions']));
    console.log(@json($motors));
    console.log(@json($finitions));
    console.log(@json($finitions_detail));

});
</script>


{{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($submodeColors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}

{{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($vehicle, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}
