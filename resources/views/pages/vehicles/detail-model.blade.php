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

    <x-utils.container class="border-b border-gray-200">
        <div class="flex flex-col items-center justify-between -my-2 md:gap-4 md:flex-row">
            <div class="flex flex-row items-center w-full md:gap-4 justify-beetween md:w-auto">
                <div class="flex-1 md:order-2">
                    <h1 class="flex flex-wrap gap-2 h1" style="margin:0;">
                        <span>{{ $vehicle['model']['makeName'] }}</span>
                        <span><b class="font-normal">{{ $vehicle['model']['submodelCommercialName'] ?? $vehicle['model']['modelName'] }}</b></span></h1>
                    {{-- <p class="text-sm md:text-md">Découvrez les modèles de la marque {{ $make['name'] }} disponibles en Belgique, {{ strftime('%B %Y') }}</p> --}}
                </div>
                <img src="{{ $make['logo'] }}" class="w-30 md:w-24 md:order-1">
            </div>
            @if(isset($vehicle['summary']['minPrice']))
                <div class="flex items-center w-full gap-4 md:w-auto">
                    <div class="flex-1 text-xs">Prix à partir de</div>
                    <div class="text-xs"><span class="mr-1 text-3xl font-extrabold md:text-3xl">{{ number_format($vehicle['summary']['minPrice'], 0, ',', '.') . ' €' }}</span> TTC*</div>
                </div>
            @endif
        </div>
    </x-utils.container>

    <x-utils.container class="py-6">
        <div class="text-center md:text-left">
            <h2 class="mb-2 text-2xl">Configurez votre voiture</h2>
            <p class="text-xs">Choisissez la finition, le moteur ainsi que toutes les options pour votre nouveau vehicule.</p>
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

    @if(isset($vehicle['model']['images']))
        <div x-data="{
                expanded: false,
                init() {
                    this.scroller = $el.children[0];
                    this.scroller.scrollTo(0,0);
                },
                expand (event) {
                    this.expanded = true;
                },
                collapse (event) {
                    this.expanded = false;
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
            }" class="py-4  flex flex-col" :class="expanded ? 'fixed bg-black text-white top-0 left-0 right-0 bottom-0 z-100 h-screen w-screen' : 'bg-gray-50'">
            <div class="flex-1 max-w-full overflow-auto cursor-pointer select-none snap-x snap-mandatory scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;" >
                <div class="flex flex-nowrap" :class="expanded ? 'w-screen h-full' : 'gap-3 px-4 h-120 md:h-96'" style="width:fit-content;">
                    @foreach ($vehicle['model']['images'] as $image)
                        @if(isset($image['image800']))
                            <div class="relative h-full" :class="expanded ? 'w-screen flex items-center' : 'aspect-9/16 md:aspect-4/3 w-full'">
                                <a href="javascript:void(0)" class="absolute p-1 text-white bg-black rounded-full icon top-3 right-3" :class="expanded ? 'icon-times text-xl fixed top-4 right-4' : 'icon-expand'" @click="( expanded ? collapse(event) : expand(event) ) "></a>
                                <img src="{{ $image['image800'] }}" loading="lazy" class=" w-full h-full snap-center" @click="expand" :class="expanded ? 'object-contain max-h-[80vh]' : 'object-cover'">
                            </div>
                        @endif
                    @endforeach
                    <div>&nbsp;</div>
                </div>
            </div>
            <div class="flex items-center justify-center max-w-screen-xl gap-4 px-4 mx-auto mt-4">
                <div class="p-2 font-light rounded-full shadow-lg cursor-pointer text-md icon icon-chevron-left hover:opacity-90" @click="back" :class="expanded ? '' : 'bg-white'"></div>
                <div class="p-2 font-light rounded-full shadow-lg cursor-pointer text-md icon icon-chevron-right hover:opacity-90" @click="next" :class="expanded ? '' : 'bg-white'"></div>
            </div>
        </div>
    @endif

    <x-utils.container class="py-4 md:py-2">
        <div>
            <h2 class="text-2xl">Couleurs</h2>

        </div>
    </x-utils.container>

    {{-- <pre class="max-w-full overflow-auto text-xs">{{ json_encode($vehicle, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}

</x-layouts.app>
