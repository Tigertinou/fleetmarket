<x-layouts.app :title="'Accueil'">

    <x-utils.container class="bg-black py-4 md:py-6">
        <div class="mb-6 text-center text-white">
            <h1 class="h1">Trouvons ensemble la voiture de vos rêves</h1>
            <p>Comparez les options, les prix et les promotions en temps réel parmi plus de 500 modèles de véhicules</p>
        </div>

        <div class="flex flex-col max-w-2xl px-6 py-6 md:mx-auto mt-2 bg-white rounded-xl mx-2">
            <p class="mb-2 text-xs"><span class="inline-block mr-2 align-middle icon icon-search"></span><span>Recherchez votre voiture > configurez > comparez</span></p>
            <x-forms.search />
        </div>
    </x-utils.container>

    <x-utils.container class="py-4 md:py-6">
        <div class="text-center">
            <h2 class="h1">Quelle marque préférez-vous ?</h2>
            <p>Choisissez parmi les <span class="brands-count"></span> marques du marché belge</p>
            <div class="flex flex-wrap justify-center max-w-screen-xl mx-auto my-4" id="brands-grid"></div>
        </div>
    </x-utils.container>


    <x-utils.container class="py-4 md:py-6 bg-gray-50">
        <div class="text-center">
            <h2 class="h1">Comment fonctionne Fleet<span class="text-theme">Market</span> ?</h2>
            <p class="italic">Découvrez-le en 3 étapes ...</p>
            <div class="flex flex-col items-center justify-center max-w-screen-xl gap-4 mx-auto text-sm md:flex-row">
                <div class="flex-1 pt-6">
                    <div><div class="relative flex items-center justify-center w-16 h-16 m-auto mb-4 text-3xl font-extrabold border-2 rounded-full border-theme shadow-lg">
                    <span class="mt-1 font-normal icon icon-cog"></span>
                    <span class="absolute w-6 h-6 text-sm font-normal leading-6 text-white bg-black rounded-full -left-3">1</span>
                    </div></div>
                    <div class="mb-2 text-lg font-extrabold">Configurez <span class="font-normal">votre voiture idéale</span></div>
                    <div>FleetMarket vous propose le configurateur le plus avancé. Utilisez jusqu'à 16 filtres différents sur plus de 500 modèles pour trouver votre voiture idéale.</div>
                </div>
                <div class="flex-1 pt-6">
                    <div><div class="relative flex items-center justify-center w-16 h-16 m-auto mb-4 text-3xl font-extrabold border-2 rounded-full border-theme shadow-lg">
                        <span class="mt-1 font-normal icon icon-car-compare"></span>
                        <span class="absolute w-6 h-6 text-sm font-normal leading-6 text-white bg-black rounded-full -left-3">2</span>
                        </div></div>
                    <div class="mb-2 text-lg font-extrabold">Comparez <span class="font-normal">avec d'autres modèles</span></div>
                    <div>Vous hésitez encore ? Profitez de notre dispositif pour comparer votre voiture préférée à d'autres modèles. Découvrez l'apparence d'une voiture avec nos 360 ° salles d'exposition virtuelles.</div>
                </div>
                <div class="flex-1 pt-6">
                    <div><div class="relative flex items-center justify-center w-16 h-16 m-auto mb-4 text-3xl font-extrabold border-2 rounded-full border-theme shadow-lg">
                        <span class="mt-1 font-normal icon icon-user-dealer"></span>
                        <span class="absolute w-6 h-6 text-sm font-normal leading-6 text-white bg-black rounded-full -left-3">3</span>
                        </div></div>
                    <div class="mb-2 text-lg font-extrabold">Faites une demande <span class="font-normal">gratuitement et sans engagement</span></div>
                    <div>Demandez un devis ou un essai sur route en quelques clics. Nous vous contacterons et vous mettrons en contact gratuitement avec le revendeur officiel le plus proche !</div>
                </div>

            </div>
        </div>
    </x-utils.container>

</x-layouts.app>
<script>
document.addEventListener('DOMContentLoaded', function () {

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
    });
});
</script>
