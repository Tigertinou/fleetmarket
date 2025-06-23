{{-- Header --}}
<header class="sticky top-0 bg-white border-b border-gray-200 z-100" 
x-data="{ 
        navOpen: false, 
        globalSearchOpen: false, 
        toggleGlobalSearch(){
            this.globalSearchOpen = !this.globalSearchOpen;
            if (this.globalSearchOpen) {
                this.navOpen = false;
                setTimeout(() => {
                    $refs.inpGlobalSearch.focus();
                    $refs.inpGlobalSearch.select();
                }, 100);
            }
        }, 
        globalSearch(key){
            document.location.href=`{{ localized_route('pages.vehicles.search') }}?key=${key}`;
        }
    }" x-init="init()">
    {{-- Mobile search --}}
    {{-- Container --}}
    <div class="relative flex items-center max-w-screen-xl px-4 mx-auto min-h-18 md:min-h-24 whitespace-nowrap">
        {{-- Logo --}}
        <div class="items-center justify-center flex-1 order-1 md:order-1 md:flex-none md:mr-4 flex" x-show="!globalSearchOpen">
            <a href="{{ localized_route('pages.home') }}" class="block mr-auto w-auto self-start pl-1">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="FleetMarket logo" class="h-8 md:my-2 md:mr-4 md:h-10">
            </a>
        </div>
        <nav class="flex items-center md:flex-1 order-0 md:order-2" x-show="!globalSearchOpen">
            <ul class="flex-row items-center justify-center flex-1 hidden w-full space-x-5 md:flex md:justify-start nowrap">
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Actualités</a></li>
                <li><a href="{{ localized_route('pages.vehicles.search') }}" class="hover:text-theme">Rechercher</a></li>
                <li><a href="{{ localized_route('pages.vehicles.compare') }}" class="hover:text-theme">Comparer</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Guide d’achat</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Comment ça marche</a></li>
            </ul>
        </nav>
        <div id="global-search" class="flex self-stretch flex-1" x-show="globalSearchOpen" x-cloak>
            <div class="self-center pr-2 text-lg text-gray-400 icon icon-search"></div>
            <input x-ref="inpGlobalSearch" class="self-stretch flex-1 border-0 outline-0 text-sm" name="inp_global_search" placeholder="Recherche par marques, modèle ou mot-clé" @keyup.enter="globalSearch($event.target.value)" @keyup.esc="toggleGlobalSearch" type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
        </div>
        <div class="order-2 mx-2 md:order-3">
            <a href="javascript:void(0);" @Click="toggleGlobalSearch" class="hover:text-theme"><span class="text-xl icon" :class="globalSearchOpen ? 'icon-times' : 'icon-search'"></span></a>
        </div>
        <div class="order-3 mx-2 md:order-4" x-show="!globalSearchOpen">
            <a href="javascript:void(0);" x-on:click="navOpen = ! navOpen" class="hover:text-theme"><span class="text-xl icon" :class="navOpen ? 'icon-times' : 'icon-burger'"></span></a>
        </div>
        {{--  --}}
        <div x-show="navOpen && !globalSearchOpen" x-cloak>
            <ul class="fixed bottom-0 right-0 z-10 flex flex-col w-full gap-3 px-8 py-6 transition-all duration-300 ease-in-out bg-white border-b border-gray-200 shadow-xl md:absolute md:bottom-auto justify-top md:border top-18 nowrap md:w-auto md:top-24 md:text-sm">
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Actualités</a></li>
                <li><a href="{{ localized_route('pages.vehicles.search') }}" class="hover:text-theme">Rechercher</a></li>
                <li><a href="{{ localized_route('pages.vehicles.compare') }}" class="hover:text-theme">Comparer</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Guide d’achat</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Comment ça marche</a></li>
                <li class="border-t border-gray-100"></li>
                <li><a href="{{ localized_route('pages.elements') }}" class="hover:text-theme">Elements UIUX</a></li>
                <li><a href="/assets/fonts/fleetmarket.v1.1/icons-reference.html" class="hover:text-theme">Icons</a></li>
            </ul>
        </div>
    </div>
</header>

