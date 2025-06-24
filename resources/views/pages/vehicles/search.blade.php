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
        init() {}
        }">
        <div class="flex gap-4 px-4">
            <div class="flex-1">
                <div class="pt-6">
                    <h1 class="h1">Les offres du mois</h1>
                    <p class="text-sm md:text-md">Les meilleures offres en Belgique, {{ strftime('%B %Y') }}</p>
                    
                    @if(count($filters) > 0)
                        <div class="flex flex-wrap gap-1 py-3 my-4 border-gray-200 border-y empty:hidden">
                            @foreach($filters as $key => $filter)
                                @foreach ($filter['values'] as $value)
                                    <x-utils.label r-icon="icon-times" title="{{ $filter['label']}}" class="cursor-pointer" onclick="window.removeParams('{{ $filter['type'] }}','{{ $value['code'] }}');this.remove();">
                                        {{-- {{ $filter['label']}}</b> :  --}}{{ $value['label'] }}
                                    </x-utils.label>
                                @endforeach
                            @endforeach
                        </div>
                        {{--
                        <x-utils.label r-icon="icon-times">
                            <b>{{ $filter['label']}}</b> : {{ collect($filter['values'])->pluck('label')->implode(', ')}}
                        </x-utils.label>
                        --}}
                    @endif

                    {{-- <pre>{{ json_encode($filters, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}

                    <div class="items-center md:flex">
                        <div class="flex flex-wrap items-center gap-2 text-sm md:justify-end md:order-2">
                            <x-utils.button label="Recommandations" r-icon="icon-chevron-down" color="bordered" size="md" class="flex-1 md:w-auto" @click="suggestionsOpen=true"></x-utils.button>
                            <x-utils.button label="Filtres" r-icon="icon-filter" color="bordered" size="md" class="flex-1 md:w-auto md:hidden" @click="filtersOpen=true"></x-utils.button>
                        </div>

                        <div class="w-full pt-4 text-sm md:order-1 md:pt-0"><b class="font-bold" data-var="totalFound">0</b> véhicules trouvés</div>
                    </div>

                    <div x-data="{ shown : false }" x-intersect:leave="shown = true" x-intersect:enter="shown = false">
                        <div x-show="shown" class="fixed z-20 bottom-4 right-3" x-transition>
                            <div class="p-3 text-xl font-light text-white bg-black rounded-full shadow-lg icon icon-filter" @click="filtersOpen=true"></div>
                        </div>
                    </div>

                    <div class="mt-4" id="search-results">
                        {{-- @include('partials.vehicles.search.results')--}}
                    </div>

                    <x-layouts.modal title="Recommandations" ref="suggestions">
                        <div class="flex flex-col">
                            <a href="" class="py-3 border-b border-gray-100">Nos recommandations</a>
                            <a href="" class="py-3 border-b border-gray-100">Meilleurs ventes</a>
                            <a href="" class="py-3 border-b border-gray-100">Du plus économique au plus cher</a>
                            <a href="" class="py-3 border-b border-gray-100">Du plus cher au plus économique</a>
                            <a href="" class="py-3 border-b border-gray-100">De A-Z</a>
                            <a href="" class="py-3 border-b border-gray-100">De Z-A</a>
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
    /*
    window.loadSearchResults(params.toString());
    history.pushState({}, '', window.location.pathname + '?' + params.toString());*/
    document.location.href = `{{ localized_route('pages.vehicles.search') }}?${params.toString()}`;
}

window.loadSearchResults = function(params = window.location.search) {
    params = new URLSearchParams(params);
    fetch('/{{ app()->getLocale() }}/partials/vehicles/search/results?' + params.toString())
    .then(response => {
        const total = response.headers.get('X-Total-Count');
        if (total !== null) {
            document.querySelectorAll('[data-var="totalFound"]').forEach( (el)=>{
                el.innerHTML = total;
            })
        }
        return response.text();
    })
    .then(html => {
        document.getElementById('search-results').innerHTML = html;
    });
}

window.reloadFilters = function(){
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => {
        document.querySelectorAll(`[name="inp_${key}"]`).forEach((el) => {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = value.split(',').includes(el.value);
            } else {
                el.value = value;
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    window.loadSearchResults();
    window.reloadFilters();

    document.querySelector('#run-filter').addEventListener('click',()=>{
        const params = new URLSearchParams({
            price_min: document.querySelector('[name="inp_price_min"]')?.value,
            price_max: document.querySelector('[name="inp_price_max"]')?.value,
            bodytype : [...document.querySelectorAll('[name="inp_bodytype"]:checked')].map(input => input.value).join(','),
            brands : [...document.querySelectorAll('[name="inp_brands"]:checked')].map(input => input.value).join(',')
        });
        document.location.href=`{{ localized_route('pages.vehicles.search') }}?${params.toString()}`;
    })
    /*
    window.api.motork.getMakes().then(function (makes) {
        const list = document.querySelector('#brands-grid');
        if(list!=null){
            makes.forEach(item => {
                let el = document.createElement('a');
                el.href = `{{ localized_route('pages.vehicles.search') }}?inp_brands=${ item.id }`;
                el.setAttribute('class', 'bg-white flex items-center justify-center outline-1 outline-gray-200 p-4 cursor-pointer hover:bg-gray-50 ');
                el.innerHTML = `<img src="${ item.logo }" class="w-20 md:w-24">`;
                list.appendChild(el);
            });
            document.querySelector('.brands-count').textContent = makes.length;
        }
    }).catch(function (error) {
        console.error('Error fetching makes:', error);
    });*/
});
</script>
