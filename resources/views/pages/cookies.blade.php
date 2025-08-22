@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => __tl('Politique de cookies')]
]
@endphp
<x-layouts.app :title="'Politique de cookies'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Politique de cookies</h1>
        <p class="my-4">...</p>
    </x-utils.container>

</x-layouts.app>
