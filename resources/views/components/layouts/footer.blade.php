{{-- Footer --}}
<footer class="py-4 bg-gray-100">
    <div class="max-w-screen-xl px-4 py-4 mx-auto">
        <img src="https://fleetmarket.test/assets/images/logo.svg" alt="FleetMarket logo" class="h-8 mb-4 md:mr-4 md:h-10">
        <div class="flex flex-col gap-4 text-xs md:flex-row">
            <div class="flex flex-col justify-start gap-2 pb-4 border-b border-gray-300 md:flex-1/3">
                <a href="{{ localized_route('pages.vehicles.search') }}" class="text-black underline">{{ __tl('Offres') }}</a>
                {{-- <a href="{{ localized_route('pages.vehicles.search') }}" class="text-black underline">{{ __tl('Location Longue Durée') }}</a> --}}
                <a href="{{ localized_route('pages.vehicles.search',[ 'fueltype' => 'mild-hybrid,plug-in-hybrid,electrique,full-hybrid' ]) }}" class="text-black underline">{{ __tl('Voitures électriques et hybrides') }}</a>
                <a href="{{ localized_route('pages.vehicles.search',[ 'price_min' => '', 'price_max' => '25000' ]) }}" class="text-black underline">{{ __tl('Liste prix de voitures jusqu’à 25.000 €') }}</a>
                <a href="{{ localized_route('pages.vehicles.search',[ 'price_min' => '35000', 'price_max' => '50000' ]) }}" class="text-black underline">{{ __tl('Liste prix de voitures entre 35.000 et 50.000 €') }}</a>
                <a href="{{ localized_route('pages.vehicles.search',[ 'price_min' => '50000', 'price_max' => '' ]) }}" class="text-black underline">{{ __tl('Liste prix de voitures à partir de 50.000 €') }}</a>
            </div>
            <div class="flex flex-col justify-start gap-2 pb-4 border-b border-gray-300 md:flex-1/3">
                <a href="{{ localized_route('pages.vehicles.compare') }}" class="text-black underline">{{ __tl('Comparer') }}</a>
                <a href="{{ localized_route('pages.home') }}" class="text-black underline">{{ __tl('Guides d’achat') }}</a>
                <a href="{{ localized_route('pages.home') }}" class="text-black underline">{{ __tl('Qui sommes-nous') }}</a>
                <a href="{{ localized_route('pages.home') }}" class="text-black underline">{{ __tl('Comment ça marche') }}</a>
            </div>
            <div class="flex flex-col justify-start gap-2 pb-4 border-b border-gray-300 md:flex-1/3">
                <a href="{{ localized_route('pages.legals') }}" class="text-black underline">{{ __tl('Mentions légales') }}</a>
                <a href="{{ localized_route('pages.legals') }}" class="text-black underline">{{ __tl('Politique de confidentialité') }}</a>
                <a href="{{ localized_route('pages.legals') }}" class="text-black underline">{{ __tl('Conditions générales d’utilisation') }}</a>
                <a href="{{ localized_route('pages.legals') }}" class="text-black underline">{{ __tl('Politique de cookies') }}</a>
            </div>
        </div>
        {{-- <div class="flex items-center justify-center mt-4">
            <a href="https://www.facebook.com/fleetmarket.be" target="_blank" class="text-gray-500 hover:text-gray-700">
                <span class="text-2xl icon icon-facebook"></span>
            </a>
            <a href="https://www.instagram.com/fleetmarket.be/" target="_blank" class="ml-4 text-gray-500 hover:text-gray-700">
                <span class="text-2xl icon icon-instagram"></span>
            </a>
            <a href="https://www.linkedin.com/company/fleetmarket-be/" target="_blank" class="ml-4 text-gray-500 hover:text-gray-700">
                <span class="text-2xl icon icon-linkedin"></span>
            </a>
        </div> --}}
        <div class="mt-4 text-sm">
            &copy; {{ date('Y') }}&nbsp;<b class="font-bold text-black">FleetMarket</b>. {{ __tl('Tous droits réservés.') }}
        </div>
        <div class="mt-4 text-xs text-gray-500">
            {{ __tl('FleetMarket s’engage à maintenir et à mettre à jour régulièrement tout le contenu de ce site Web. Malgré tout, FleetMarket ne garantit pas l’exactitude des informations contenues dans le site, qui peuvent devenir obsolètes par erreur ou oubli. FleetMarket ne pourra pas être tenu responsable des éventuelles erreurs ou lacunes, ou des dommages directs, indirects, conséquences ou de n’importe quel autre type de dommages en lien avec l’utilisation du présent site Web ou des fonctions contenues dans celui-ci.') }}
        </div>
    </div>
</footer>
