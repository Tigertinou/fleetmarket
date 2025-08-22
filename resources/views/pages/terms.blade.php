@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => __tl('Conditions générales d’utilisation')]
]
@endphp
<x-layouts.app :title="'Conditions générales d’utilisation'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Conditions générales d’utilisation</h1>
        <p class="my-4">...</p>
    </x-utils.container>

</x-layouts.app>
