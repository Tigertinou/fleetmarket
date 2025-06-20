@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="icon icon-home font-thin text-xs" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Page']
]
@endphp
<x-layouts.app :title="'Page'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Title</h1>
        <p>Sub title</p>
    
    </x-utils.container>

</x-layouts.app>