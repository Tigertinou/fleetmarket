{{-- Header --}}
<header class="bg-white border-b border-gray-200" x-data="{ navOpen: false }">
    {{-- Container --}}
    <div class="relative flex items-center max-w-screen-xl px-4 mx-auto min-h-16 md:min-h-24 whitespace-nowrap">
        {{-- Logo --}}
        <div class="items-center justify-center flex-1 order-2 text-center md:order-1 md:flex-none md:mr-4"><a href="{{ localized_route('pages.home') }}" class="inline-block"><img src="{{ asset('assets/images/logo.svg') }}" alt="FleetMarket logo" class="h-8 mt-2 md:my-2 md:mr-4 md:h-10"></a></div>
        <nav class="flex items-center md:flex-1 order-0 md:order-2">
            <ul class="flex-row items-center justify-center flex-1 hidden w-full space-x-5 md:flex md:justify-start nowrap">
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Actualités</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Rechercher</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Comparer</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Guide d’achat</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Comment ça marche</a></li>
            </ul>
        </nav>
        <div class="order-3 mx-2 md:order-3"><a href="{{ localized_route('pages.home') }}" class="hover:text-theme"><span class="text-lg icon icon-search md:text-xl"></span></a></div>
        <div class="order-1 mx-2 md:order-4"><a href="javascript:void(0);" x-on:click="navOpen = ! navOpen" class="hover:text-theme"><span class="text-lg icon md:text-xl" :class="navOpen ? 'icon-times' : 'icon-burger'"></span></a></div>
        {{--  --}}
        <div x-show="navOpen" x-cloak>
            <ul class="absolute right-0 z-10 flex flex-col justify-center w-full gap-3 px-8 py-6 transition-all duration-300 ease-in-out bg-white border-b border-gray-200 shadow-xl md:border top-16 nowrap md:w-auto top-full md:text-sm">
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Actualités</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Rechercher</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Comparer</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Guide d’achat</a></li>
                <li><a href="{{ localized_route('pages.home') }}" class="hover:text-theme">Comment ça marche</a></li>
            </ul>
        </div>
    </div>
</header>
