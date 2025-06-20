@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Recherche']
]
@endphp
<x-layouts.app :title="'Page'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Recherche</h1>
        <p>Les meilleures offres en Belgique, {{ strftime('%B %Y') }}</p>

    </x-utils.container>

</x-layouts.app>
