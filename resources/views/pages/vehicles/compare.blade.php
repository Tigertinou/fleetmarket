@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Comparer véhicules']
]
@endphp
<x-layouts.app :title="'Comparer véhicules'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Comparer véhicules</h1>
        <p><i>{{ __tl('Bientôt disponible...') }}</i></p>

    </x-utils.container>

</x-layouts.app>
