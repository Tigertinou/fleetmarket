@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Recherche']
]
@endphp
<x-layouts.app :title="'Page'" :$breadcrumb>

    <div class="max-w-screen-xl mx-auto" x-data="{
        filtersOpen: true,
        init() {}
        }">
        <div class="flex gap-4 px-4">
            <div class="flex-1">
                <div class="pt-6">
                    <h1 class="h1">Recherche</h1>
                    <p>Les meilleures offres en Belgique, {{ strftime('%B %Y') }}</p>

                    <div class="py-4">
                        <x-utils.button label="Filtres" r-icon="icon-filter" color="gray" size="md" @click="filtersOpen=true"></x-utils.button>
                    </div>

                    <div>Results...</div>


                </div>
            </div>
            <div class="absolute top-0 left-0 right-0 h-screen px-4 bg-white border-l border-gray-200 z-100 side-filter md:w-xs md:relative md:h-auto md:z-5" x-show="filtersOpen || !isMobile" x-cloak>
                <div>
                    <div class="flex items-center justify-between py-4 md:hidden">
                        <div class="text-2xl">Filtres</div>
                        <a href="javascript:void(0);" @click="filtersOpen=!filtersOpen"><i class="text-2xl icon icon-times"></i></a>
                    </div>
                    <div class="flex justify-end my-4">
                        <a href="" class="text-xs font-semibold underline">Supprimer tous les filtres <i class="icon icon-times"></i></a>
                    </div>
                    <details open>
                        <summary class="pl-4 -ml-4">Prix</summary>
                        <div class="flex flex-col gap-2 pb-4">
                            <div>
                                <label class="text-xs font-semibold">Prix</label>
                                <x-forms.elements.range name="inp_price" min="0" max="100000" min-value="5000" max-value="95000" step="5000"/>
                            </div>
                            <div>
                                <x-forms.elements.checkbox class="inline-block mt-4" name="inp_promotion" label="Promotions"/>
                            </div>
                        </div>
                    </details>

                    <details open>
                        <summary class="pl-4 -ml-4">Solutions de financement</summary>
                        <div class="flex flex-col gap-2 pb-4">
                            <div>
                                <label class="text-xs font-semibold">Loyer mensuel</label>
                                <x-forms.elements.range name="inp_" min="50" max="2000" min-value="50" max-value="2000" step="1"/>
                            </div>
                            <div>
                                <x-forms.elements.checkbox class="block my-1" name="inp_" label="Location avec Option d'Achat"/>
                                <x-forms.elements.checkbox class="block my-1" name="inp_" label="Location Longue Durée"/>
                            </div>
                        </div>
                    </details>

                    <details>
                        <summary class="pl-4 -ml-4">Carburant</summary>
                        <div class="flex flex-col gap-2 pb-4">
                            <div>
                                {{-- <x-forms.elements.checkbox class="block my-1" size="lg" name="inp_fuelType" label="Diesel" value="1"/>
                                <x-forms.elements.checkbox class="block my-1" size="lg" name="inp_fuelType" label="Essence" value="2"/> --}}
                                @foreach ($facets['fuelType'] as $key => $facet)
                                    <x-forms.elements.checkbox
                                        class="block my-1 capitalize"
                                        size="lg"
                                        name="inp_fuelType"
                                        :label="$facet['label'] ?? ''"
                                        :value="$facet['value'] ?? ''"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </details>

                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
