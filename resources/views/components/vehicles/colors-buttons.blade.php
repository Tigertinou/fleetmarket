@props([
    "colors" => [],
])
<div class="flex flex-wrap items-center justify-center gap-2 p-2 mt-4 mb-2 ">
    @foreach ($colors as $key => $color)
        @php
            $c = $color['primaryHex'] ?? '#000000';
            $cClass = '';
            if(preg_match('/m[ée]tal/iu', $color['group']) === 1){
                $cClass = 'vcolors-metallic';
            } else if(preg_match('/opa[qc]/iu', $color['group']) === 1) {
                $cClass = 'vcolors-opac';
            }
        @endphp
        <span class="vcolors-item w-12 h-12 border-white rounded-full border-4 outline-2 cursor-pointer hover:opacity-80 {{$cClass}}"
        style="background:{{ $c }};"
        title="{{$color['description']}} - {{$color['group']}}"
        :class="(selected == $el ? 'outline-theme' : 'outline-gray-200') @if($key > 4)+ (showAll ? '' : ' hidden')@endif"
        data-color="{{ $color['primaryHex'] }}"
        data-description="{{$color['description']}}"
        data-group="{{$color['group']}}"
        data-price="{{$color['basePrice']}}"
        data-image="{{ $color['colorImage']['image800'] ?? '' }}"
        @click="select"></span>
    @endforeach
    @if(count($colors) > 4)
        <span class="flex items-center justify-center w-12 h-12 border-4 border-white rounded-full cursor-pointer outline-2 outline-gray-100" @click="showAll=!showAll"><i class="text-2xl icon " :class="showAll ? 'icon-minus' : 'icon-plus'"></i></span>
    @endif
</div>
