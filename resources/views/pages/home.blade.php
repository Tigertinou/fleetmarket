<x-layouts.app :title="'Accueil'">

    <div class="py-4 bg-black md:py-6">
        <div class="max-w-screen-xl px-4 py-4 mx-auto md:py-6">
            <div class="mb-6 text-white">
                <h1 class="h1">Trouvons ensemble votre nouvelle voiture</h1>
                <p>Comparez les options, les prix et les promotions en temps réel parmi plus de 500 modèles de véhicules</p>
            </div>

            <div class="flex flex-col max-w-sm px-6 py-4 mx-auto mt-2 bg-white rounded-xl">
                <x-forms.search />
            </div>

        </div>
    </div>

    <div class="py-4">
        <x-forms.search class="max-w-screen-xl px-4 mx-auto mt-4 md:mt-6" />
    </div>

</x-layouts.app>
