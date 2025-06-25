@props([
    "value" => null,
])
@php
    $value = strtoupper($value);
@endphp
@if(in_array($value,['A','B','C','D','E','F','G']) )
    <span {{ $attributes->merge(['class' => 'relative inline-block pl-1 pr-2 py-0 leading-4 text-xs text-white font-semibold mr-4 bg-efficiency-' . $value]) }} >
        {{ $value }}
        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute left-full top-0 h-full w-2 fill-efficiency-{{ $value }}">
            <polygon points="0,0 100,50 0,100" />
        </svg>
    </span>
@endif