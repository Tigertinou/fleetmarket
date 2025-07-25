@props([
    "colors" => [],
])
<div class="flex flex-wrap items-center justify-center gap-2 p-2 mt-4 mb-2 ">
    @foreach ($colors as $key => $color)
        @php
            $c = $color['primaryHex'] ?? $color['baseColourHex'] ?? '#000000';
        @endphp
        <span class="w-12 h-12 border-4 border-white rounded-full cursor-pointer vcolors-item outline-2 hover:opacity-80"
        style="background:{{ $c }};"
        title="{{$color['description']}} - {{$color['group']}}"
        :class="(selected == $el ? 'outline-theme' : 'outline-gray-200') @if($key > 4)+ (showAll ? '' : ' hidden')@endif"
        data-color="{{ $color['primaryHex'] ?? $color['baseColourHex'] }}"
        data-description="{{$color['description']}}"
        data-group="{{$color['group']}}"
        data-price="{{$color['msrpPrice']}}"
        data-value="{{ $color['code'] }}"
        data-image="{{ $color['colorImage']['image800'] ?? '' }}"
        data-color-type="{{ $color['colorType'] ?? 'other' }}"
        @click="select"></span>
    @endforeach
    @if(count($colors) > 4)
        <span class="flex items-center justify-center w-12 h-12 border-4 border-white rounded-full cursor-pointer outline-2 outline-gray-100" @click="showAll=!showAll"><i class="text-2xl icon " :class="showAll ? 'icon-minus' : 'icon-plus'"></i></span>
    @endif
</div>
<script>

</script>
