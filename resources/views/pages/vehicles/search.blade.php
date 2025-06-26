@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Recherche']
]
@endphp
<x-layouts.app :title="'Page'" :$breadcrumb>
    <div id="main" class="max-w-screen-xl mx-auto" x-data="{
        filtersOpen: false,
        suggestionsOpen: false,
        facets: [],
        removeFacet(facet) {
            window.removeParams(facet.type, facet.code);
            this.facets = this.facets.filter(f => f.code !== facet.code);
        },
        paginate(page) {
            if(page==null){ return; }
            const params = new URLSearchParams(window.searchParams || document.location.search);
            params.set('page', page);
            window.searchParams = params.toString();
            window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
            window.loadSearchResults(params.toString());
        },
        init() {}
        }">
        <div class="flex gap-4 px-4">
            <div class="flex-1">
                <div class="pt-6">

                    @if($make)
                        <div class="flex items-start gap-4 mb-4">
                            <div class="flex-1">
                                <h1 class="h1">Les offres {{ $make['name'] }} du mois</h1>
                                <p class="text-sm md:text-md">Découvrez les modèles de la marque {{ $make['name'] }} disponibles en Belgique, {{ strftime('%B %Y') }}</p>
                            </div>
                            <img src="{{ $make['logo'] }}" class="w-20 md:w-24">
                        </div>
                    @else
                        <h1 class="h1">Les offres du mois</h1>
                        <p class="text-sm md:text-md">Les meilleures offres en Belgique, {{ strftime('%B %Y') }}</p>
                    @endif

                    <div class="flex flex-wrap gap-1 py-3 my-4 border-gray-200 border-y" x-show="facets.length > 0">
                        <template x-for="facet in facets">
                            <x-utils.label r-icon="icon-times" class="cursor-pointer" @click="removeFacet(facet);">
                                <span x-text="facet.label"></span>
                            </x-utils.label>
                        </template>
                    </div>
                    <div class="mt-4 mb-4 border-b border-gray-200" x-show="facets.length == 0"></div>

                    {{-- @if(count($filters) > 0)
                        <div class="flex flex-wrap gap-1 py-3 my-4 border-gray-200 border-y">
                            @foreach($filters as $key => $filter)
                                @foreach ($filter['values'] as $value)
                                    @if(isset($filter['label']))
                                        <x-utils.label r-icon="icon-times" title="{{ $filter['label'] }}" class="cursor-pointer" onclick="window.removeParams('{{ $filter['type'] }}','{{ $value['code'] }}');this.remove();">
                                        {{ $value['label'] }}
                                        </x-utils.label>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <div class="mt-4 mb-4 border-b border-gray-200"></div>
                    @endif --}}

                    <div class="items-center md:flex">
                        <div class="flex flex-wrap items-center gap-2 text-sm md:justify-end md:order-2">
                            <x-utils.button r-icon="icon-chevron-down" color="bordered" size="md" class="flex-1 md:w-auto whitespace-nowrap" @click="suggestionsOpen=true">
                                <span id="id-sort-label">Recommandations</span>
                            </x-utils.button>
                            <x-utils.button label="Filtres" r-icon="icon-filter" color="bordered" size="md" class="flex-1 md:w-auto md:hidden" @click="filtersOpen=true"></x-utils.button>
                        </div>

                        <div class="w-full pt-4 text-sm md:order-1 md:pt-0"><b class="font-bold" data-var="totalSubmodelsFound">0</b> modèles trouvés</div>
                    </div>

                    <div x-data="{ shown : false }" x-intersect:leave="shown = true" x-intersect:enter="shown = false">
                        <div x-show="shown" class="fixed z-20 bottom-4 right-3 md:hidden" x-transition>
                            <div class="p-3 text-xl font-light bg-white border-gray-100 rounded-full shadow-lg border-1 icon icon-filter" @click="filtersOpen=true"></div>
                        </div>
                    </div>

                    <div class="mt-4" id="search-results"></div>
                    <div id="loading-results" class="flex flex-col items-center justify-center hidden gap-4 mt-12 mb-6 animate-pulse">
                        <svg class="mr-3 -ml-1 text-white size-8 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-15" cx="12" cy="12" r="10" stroke="{{-- var(--color-black) --}}" stroke-width="4"></circle><path class="opacity-75" fill="var(--color-theme)" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="text-sm font-normal text-black">Chargement des résultats...</span>
                    </div>

                    <x-layouts.modal title="Trier les vehicules par ?" ref="suggestions" id="suggestions-modal">
                        <div class="flex flex-col">
                            <a href="javascript:void(0);" data-sort="" data-label="Recommandation" class="py-3 border-b border-gray-100">Nos recommandations</a>
                            {{-- <a href="javascript:void(0);" data-sort="minPrice asc" data-label="Meilleurs ventes" class="py-3 border-b border-gray-100">Meilleurs ventes</a> --}}
                            <a href="javascript:void(0);" data-sort="minPrice asc" data-label="Les plus économiques" class="py-3 border-b border-gray-100">Du plus économique au plus cher</a>
                            <a href="javascript:void(0);" data-sort="minPrice desc" data-label="Les plus chers" class="py-3 border-b border-gray-100">Du plus cher au plus économique</a>
                            <a href="javascript:void(0);" data-sort="modelName asc" data-label="A-Z" class="py-3 border-b border-gray-100">De A-Z</a>
                            <a href="javascript:void(0);" data-sort="modelName desc" data-label="Z-A" class="py-3">De Z-A</a>
                        </div>
                    </x-layouts.modal>

                </div>
            </div>

            <div class="fixed top-0 bottom-0 left-0 right-0 px-4 overflow-auto bg-white border-l border-gray-200 md:overflow-visible z-100 side-filter md:w-sm md:relative md:h-auto md:z-5" x-show="filtersOpen || !isMobile" x-cloak>
                @include('partials.vehicles.search.filters')
            </div>

        </div>
    </div>

</x-layouts.app>
<script>
@if($make)
    let p = new URLSearchParams(window.location.search);
    p.set('makes', '{{ $make['slug'] }}');
    window.searchParams = p.toString();
    window.history.pushState({}, '', `${window.location.pathname}?${p.toString()}`);
@endif

window.searchParams = window.location.search || '';

window.removeParams = function (type,code) {
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => {
        if (key==type) {
            value = value.split(',').filter(item => item !== code).join(',');
            if (value) {
                params.set(key, value);
            } else {
                params.delete(key);
            }
        }
    });
    window.searchParams = params.toString();
    window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
    window.loadSearchResults(params.toString());
    window.populateSearch();
}

window.sortSearchResults = function (sort) {
    const params = new URLSearchParams(window.location.search);
    params.set('sort', sort);
    window.searchParams = params.toString();
    window.runSearch();
}

window.loadSearchResults = function(params = window.location.search) {
    params = new URLSearchParams(params);
    document.getElementById('search-results').innerHTML = '';
    document.getElementById('loading-results').classList.remove('hidden');
    fetch('/{{ app()->getLocale() }}/partials/vehicles/search/results?' + params.toString())
    .then(response => {
        const total = response.headers.get('X-Total-Count');
        if (total !== null && total !== '') {
            document.querySelectorAll('[data-var="totalFound"]').forEach( (el)=>{
                el.innerHTML = total;
            })
        }
        const totalSubmodels = response.headers.get('X-Total-Submodels-Count');
        if (totalSubmodels !== null && totalSubmodels !== '') {
            document.querySelectorAll('[data-var="totalSubmodelsFound"]').forEach( (el)=>{
                el.innerHTML = totalSubmodels;
            })
        }
        const facets = response.headers.get('X-Facets');
        if (facets !== null) {
            const facetsData = JSON.parse(facets);
            window.xMainData.facets = [];
            for(const facetType of facetsData) {
                for(const facet of facetType.values) {
                    if(facet.label!=null && facet.label!=''){
                        window.xMainData.facets.push({
                            id: `facet-${facetType.type}-${facet.code}`,
                            type: facetType.type,
                            code: facet.code || facet.value || facet.label,
                            label: facet.label || facet.code
                        });
                    }
                }
            }
        }
        return response.text();
    })
    .then(html => {
        document.getElementById('search-results').innerHTML = html;
        document.getElementById('loading-results').classList.add('hidden');
    });
}

window.populateSearch = function(){
    const params = new URLSearchParams(window.location.search);
    document.querySelectorAll('.range-slider').forEach((el) => {
        el.slider?.reset();
    });
    params.forEach((value, key) => {
        switch (key){
            case 'sort':
                const el = document.querySelectorAll(`[data-sort="${value}"]`)[0];
                if(el!=null){
                    document.querySelector('#id-sort-label').innerText = el.getAttribute('data-label') || el.innerText;
                }
            break;
            case 'page':

            break;
            default :
                if (!value || value.trim() == '') {
                    return;
                }
                document.querySelectorAll(`[name="inp_${key}"]`).forEach((el) => {
                    if (el.type === 'checkbox' || el.type === 'radio') {
                        el.checked = value.split(',').includes(el.value);
                    } else {
                        el.value = value;
                    }
                    if(el.isRangeSliderInput) {
                        el.updateRangeSlider();
                    }
                    el.closest('details')?.setAttribute('open', 'open');
                });
            break;
        }
    });
}

window.runSearch = function(){
    const params = new URLSearchParams(window.searchParams || document.location.search);
    params.delete('page');
    /* params.delete('offset'); */
    if(document.querySelector('[name="inp_price_min"]')?.hasChanged){ params.set('price_min', document.querySelector('[name="inp_price_min"]')?.value || '') };
    if(document.querySelector('[name="inp_price_max"]')?.hasChanged){ params.set('price_max', document.querySelector('[name="inp_price_max"]')?.value || '') };
    params.set('bodytype', [...document.querySelectorAll('[name="inp_bodytype"]:checked')].map(input => input.value).join(','));
    params.set('makes', [...document.querySelectorAll('[name="inp_makes"]:checked')].map(input => input.value ).join(','));
    params.set('traction', [...document.querySelectorAll('[name="inp_traction"]:checked')].map(input => input.value).join(','));
    params.set('fueltype', [...document.querySelectorAll('[name="inp_fueltype"]:checked')].map(input => input.value).join(','));
    params.set('gearbox', [...document.querySelectorAll('[name="inp_gearbox"]:checked')].map(input => input.value).join(','));
    params.set('doors', document.querySelector('[name="inp_doors"]:checked')?.value || '');
    params.set('seats', document.querySelector('[name="inp_seats"]:checked')?.value || '');
    params.set('traction', document.querySelector('[name="inp_traction"]:checked')?.value || '');
    /* params.set('limit', document.querySelector('[name="inp_limit"]')?.value || 20);
    params.set('offset', document.querySelector('[name="inp_offset"]')?.value || 0); */
    for (const [key, value] of params.entries()) {
        if (!value || value.trim() == '') {
            params.delete(key);
        }
    }
    window.searchParams = params.toString();
    window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
    window.loadSearchResults(params.toString());
    window.populateSearch();
    //document.location.href=`{{ localized_route('pages.vehicles.search') }}?${params.toString()}`;
}

document.addEventListener('DOMContentLoaded', function () {
    window.xMainData = document.querySelector('#main')._x_dataStack[0];
    window.loadSearchResults();
    window.populateSearch();
    document.querySelectorAll('[data-sort]').forEach(el => {
        el.addEventListener('click', function () {
            window.sortSearchResults(this.getAttribute('data-sort'));
            window.xMainData.suggestionsOpen=false;
        });
    });
});

window.addEventListener('popstate', (event) => {
    window.loadSearchResults();
    window.populateSearch();
});
</script>
