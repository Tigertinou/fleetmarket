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

                    <div class="flex flex-wrap gap-1 py-3 my-4 border-gray-200 border-y">
                        <x-utils.label label="AUDI" r-icon="icon-times" />
                        <x-utils.label label="KIA" r-icon="icon-times" />
                    </div>

                    <div class="items-center md:flex">
                        <div class="flex flex-wrap items-center gap-2 text-sm md:justify-end md:order-2">
                            <x-utils.button label="Recommandations" r-icon="icon-chevron-down" color="bordered" size="md" class="flex-1 md:w-auto" @click="suggestionsOpen=true"></x-utils.button>
                            <x-utils.button label="Filtres" r-icon="icon-filter" color="bordered" size="md" class="flex-1 md:w-auto md:hidden" @click="filtersOpen=true"></x-utils.button>
                        </div>

                        <div class="w-full pt-4 text-sm md:order-1 md:pt-0"><b class="font-bold" data-var="totalFound">0</b> véhicules trouvés</div>
                    </div>

                    <div class="mt-4" id="search-results">
                        {{-- @include('partials.vehicles.search.results')--}}
                    </div>
                    
                    <x-layouts.modal title="Recommandations" ref="suggestions">
                        <div class="flex flex-col">
                            <a href="" class="border-b py-3 border-gray-100">Nos recommandations</a>
                            <a href="" class="border-b py-3 border-gray-100">Meilleurs ventes</a>
                            <a href="" class="border-b py-3 border-gray-100">Du plus économique au plus cher</a>
                            <a href="" class="border-b py-3 border-gray-100">Du plus cher au plus économique</a>
                            <a href="" class="border-b py-3 border-gray-100">De A-Z</a>
                            <a href="" class="border-b py-3 border-gray-100">De Z-A</a>
                        </div>
                    </x-layouts.modal>
                        
                </div>
            </div>
            <div class="fixed overflow-auto top-0 left-0 right-0 bottom-0 px-4 bg-white border-l border-gray-200 z-100 side-filter md:w-sm md:relative md:h-auto md:z-5" x-show="filtersOpen || !isMobile" x-cloak>
                @include('partials.vehicles.search.filters')
            </div>
        </div>
    </div>

</x-layouts.app>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function loadSearchResults() {
        const params = new URLSearchParams({ fuel: 'diesel', body: 'suv' });

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
    loadSearchResults();
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
    