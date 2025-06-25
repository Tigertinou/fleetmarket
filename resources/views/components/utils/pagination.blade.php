@props([
    "totalPages" => 1,
    "currentPage" => 1,
    "total" => 0,
    "perPage" => 20,
])
@php
@endphp
@if($totalPages > 1)
    <div class="flex items-center justify-center py-4 md:justify-between">
        <div class="hidden text-sm md:block">
            {{ __('Page') }} <b>{{ ($currentPage - 1) * 10 + 1 }}</b> / <b>{{ min($currentPage * 10, $totalPages * 10) }}</b> {{ __('sur') }} <b>{{ $total }}</b> {{ __('resultats') }}
        </div>
        <div class="flex items-center space-x-2">

            <div class="p-2 font-light rounded-full text-md icon icon-chevron-left {{ $currentPage > 1 ? 'bg-theme text-white shadow-lg hover:opacity-90 cursor-pointer' : 'bg-gray-100 text-gray-400' }}" @click="paginate({{ $currentPage > 1 ? $currentPage + 1 : null }})"></div>
            @foreach (range(1, $totalPages) as $page)
                @if( $currentPage > $page - 3 && $currentPage < $page + 3 )
                    <div class="py-2 rounded-full text-xs leading-3 w-7 text-center font-normal {{ $currentPage == $page ? 'bg-theme text-white' : 'bg-gray-100 hover:bg-gray-100 cursor-pointer' }}" @click="paginate({{ $page }})">{{ $page }}</div>
                @endif
            @endforeach
            <div class="p-2 font-light rounded-full text-md icon icon-chevron-right {{ $currentPage < $totalPages ? 'bg-theme text-white shadow-lg hover:opacity-90 cursor-pointer' : 'bg-gray-100 text-gray-400' }}" @click="paginate({{ $currentPage < $totalPages ? $currentPage + 1 : null }})"></div>

        </div>
    </div>
@endif
