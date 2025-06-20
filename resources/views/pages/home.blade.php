<x-layouts.app :title="'Accueil'">

    <x-utils.container class="bg-black">
        <div class="mb-6 text-center text-white">
            <h1 class="h1">Trouvons ensemble votre nouvelle voiture</h1>
            <p>Comparez les options, les prix et les promotions en temps réel parmi plus de 500 modèles de véhicules</p>
        </div>

        <div class="flex flex-col max-w-2xl px-6 py-6 mx-auto mt-2 bg-white rounded-xl">
            <x-forms.search />
        </div>
    </x-utils.container>

    <x-utils.container>
        <div class="text-center">
            <h1 class="h1">Quelle marque préférez-vous ?</h1>
            <p>Choisissez parmi les <span class="brands-count"></span> marques du marché belge</p>
            <div class="flex flex-wrap justify-center max-w-screen-xl mx-auto my-4" id="brands-grid"></div>
        </div>
    </x-utils.container>
    {{-- <div class="py-4">
        <x-forms.search class="max-w-screen-xl px-4 mx-auto mt-4 md:mt-6" />
    </div> --}}

</x-layouts.app>
<script>
document.addEventListener('DOMContentLoaded', function () {

    window.api.motork.getMakes().then(function (makes) {
        const list = document.querySelector('#brands-grid');
        if(list!=null){
            makes.forEach(item => {
                let el = document.createElement('a');
                el.href = `{{ localized_route('pages.search') }}?inp_brands=${ item.id }`;
                el.setAttribute('class', 'bg-white flex items-center justify-center outline-1 outline-gray-200 p-4 cursor-pointer hover:bg-gray-50 ');
                el.innerHTML = `<img src="${ item.logo }" class="w-16 md:w-24">`;
                list.appendChild(el);
            });
            document.querySelector('.brands-count').textContent = makes.length;
        }
    }).catch(function (error) {
        console.error('Error fetching makes:', error);
    });
});
</script>
