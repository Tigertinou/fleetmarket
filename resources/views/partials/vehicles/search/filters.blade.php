<div class="pb-8">
    <div class="flex items-center justify-between py-4 md:hidden">
        <div class="text-2xl">{{ __tl('Filtres') }}</div>
        <a href="javascript:void(0);" @click="filtersOpen=!filtersOpen" aria-label="{{ __tl('Fermer les filtres') }}"><i class="text-2xl icon icon-times"></i></a>
    </div>
    <div class="flex justify-end my-4">
        <a href="?" class="text-xs font-semibold underline">{{ __tl('Supprimer tous les filtres ') }}<i class="icon icon-times"></i></a>
    </div>
    <details open>
        <summary class="pl-4 -ml-4">{{ __tl('Prix') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                <label class="text-xs font-semibold">{{ __tl('Prix') }}</label>
                <x-forms.elements.range name="inp_price" min="0" max="100000" min-value="5000" max-value="95000" step="5000"/>
            </div>
            <div>
                <x-forms.elements.checkbox class="flex mt-4" name="inp_promotion" label="{{ __tl('Promotions') }}"/>
            </div>
        </div>
    </details>

    <details open>
        <summary class="pl-4 -ml-4">{{ __tl('Solutions de financement') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                <label class="text-xs font-semibold">{{ __tl('Loyer mensuel') }}</label>
                <x-forms.elements.range name="inp_" min="50" max="2000" min-value="50" max-value="2000" step="1"/>
            </div>
            <div>
                <x-forms.elements.checkbox class="flex my-1" name="inp_rent_options" value="1" label="{{ __tl('Location avec Option d\'Achat') }}"/>
                <x-forms.elements.checkbox class="flex my-1" name="inp_rent_options" value="2" label="{{ __tl('Location Longue Durée') }}"/>
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Carburant') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($facets['fuelType'] ?? [] as $key => $facet)
                    <x-forms.elements.checkbox
                        class="flex my-3 font-normal capitalize"
                        name="inp_fueltype"
                        :label="$facet['label'] ?? ''"
                        :value="$facet['value'] ?? ''"
                    />
                @endforeach
            </div>
        </div>
    </details>

    <details open>
        <summary class="pl-4 -ml-4">{{ __tl('Marques') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($makes as $make)
                    <x-forms.elements.checkbox
                        class="flex items-center font-bold uppercase"
                        name="inp_makes"
                        :value="$make['slug'] ?? ''"
                    >
                    <span class="flex items-center flex-1"><img src="{{ $make['logo'] }}" class="w-10 mr-2"> {{ $make['name'] }}</span>
                    </x-forms.elements.checkbox>
                @endforeach
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Carosseries') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($facets['bodyType'] ?? [] as $key => $facet)
                    <x-forms.elements.checkbox
                        class="flex my-3 font-normal capitalize"
                        name="inp_bodytype"
                        :label="$facet['label'] ?? ''"
                        :value="$facet['value'] ?? ''"
                    />
                @endforeach
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Tractions') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($facets['traction'] ?? [] as $key => $facet)
                    <x-forms.elements.checkbox
                        class="flex my-3 font-normal capitalize"
                        name="inp_traction"
                        :label="$facet['label'] ?? ''"
                        :value="$facet['value'] ?? ''"
                    />
                @endforeach
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Dimensions') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                <div class="mb-2">
                    <label class="text-xs font-semibold">{{ __tl('Hauteur') }}</label>
                    <x-forms.elements.range name="inp_" min="0" max="500" min-value="0" max-value="500" step="1" prefix="cm"/>
                </div>
                <div class="mb-2">
                    <label class="text-xs font-semibold">{{ __tl('Longueur') }}</label>
                    <x-forms.elements.range name="inp_" min="0" max="500" min-value="0" max-value="500" step="1" prefix="cm"/>
                </div>
                <div class="mb-2">
                    <label class="text-xs font-semibold">{{ __tl('Largeur') }}</label>
                    <x-forms.elements.range name="inp_" min="0" max="500" min-value="0" max-value="500" step="1" prefix="cm"/>
                </div>
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Places') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($facets['seats'] ?? [] as $key => $facet)
                    <x-forms.elements.checkbox
                        class="flex my-3 font-normal capitalize"
                        name="inp_seats"
                        :label="$facet['label'] ?? ''"
                        :value="$facet['value'] ?? ''"
                    />
                @endforeach
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Portes') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($facets['doors'] ?? [] as $key => $facet)
                    <x-forms.elements.checkbox
                        class="flex my-3 font-normal capitalize"
                        name="inp_doors"
                        :label="$facet['label'] ?? ''"
                        :value="$facet['value'] ?? ''"
                    />
                @endforeach
            </div>
        </div>
    </details>

    <details>
        <summary class="pl-4 -ml-4">{{ __tl('Normes antipollution') }}</summary>
        <div class="flex flex-col gap-2 px-2 pb-6 md:px-0">
            <div>
                @foreach ($facets['emissionsClass'] ?? [] as $key => $facet)
                    <x-forms.elements.checkbox
                        class="flex my-3 font-normal capitalize"
                        name="inp_co2"
                        :label="$facet['label'] ?? ''"
                        :value="$facet['value'] ?? ''"
                    />
                @endforeach
            </div>
        </div>
    </details>
</div>
<div class="sticky bottom-0 z-10 p-4 pt-2 pb-4 -m-4 bg-white">
    <x-utils.button onclick="window.runSearch();" label="{{ __tl('Filtrer') }}" icon="icon-search" r-icon="icon-chevron-right" color="theme" size="lg" class="w-full justify-beetween" @click="filtersOpen=false" align="center"></x-utils.button>{{-- animate-pulse --}}
</div>
