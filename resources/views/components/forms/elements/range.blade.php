@props([
    "label" => null,
    "prefix" => "€",
    "name" => "range_",
    "min" => 0,
    "max" => 100000,
    "minValue" => 5000,
    "maxValue" => 95000,
    "step" => 1000,
])
<div {{ $attributes->merge(['class' => 'range-slider']) }} data-name="{{ $name }}" data-min="{{ $min }}" data-max="{{ $max }}" data-min-value="{{ $minValue }}" data-max-value="{{ $maxValue }}" data-step="{{ $step }}" >
    <div class="flex text-sm">
        <div>De <span class="font-semibold text-min"></span> {{ $prefix }}</div>
        <div class="flex-1 text-center">@if($label)<b>{{$label}}</b>@endif</div>
        <div>à <span class="font-semibold text-max"></span> {{ $prefix }}</div>
    </div>
</div>
