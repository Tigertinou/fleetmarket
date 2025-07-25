@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => __tl('Mentions légales')]
]
@endphp
<x-layouts.app :title="'Mentions légales'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Mentions légales</h1>
        <p class="my-4">FleetMarket s’engage à maintenir et à mettre à jour régulièrement tout le contenu de ce site Web. Malgré tout, FleetMarket ne garantit pas l’exactitude des informations contenues dans le site, qui peuvent devenir obsolètes par erreur ou oubli. FleetMarket ne pourra pas être tenu responsable des éventuelles erreurs ou lacunes, ou des dommages directs, indirects, conséquences ou de n’importe quel autre type de dommages en lien avec l’utilisation du présent site Web ou des fonctions contenues dans celui-ci.</p>

        <p class="my-4">Copyright © FleetMarket. All Rights Reserved.</p>

        <p class="my-4">FleetMarket has been diligent in providing accurate and complete information. However, FleetMarket does not warrant the accuracy or completeness of the data. Please use care in your use of the information provided.</p>
    </x-utils.container>

</x-layouts.app>
