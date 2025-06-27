@props([
    "colors" => [],
])
@if(isset($colors) && count($colors) > 0)
    <div x-data="{
        selected: null,
        showAll: false,
        init() {
            this.select({ target : this.$el.querySelector('.vcolors-item') });
        },
        select (event) {
            this.selected = event.target;
            if(this.selected.dataset.image != '') {
                $el.querySelector('.vcolors-image').style.backgroundImage = 'url(' + this.selected.dataset.image + ')';
            }
            $el.querySelector('.vcolors-label').innerHTML = `<b>${this.selected.dataset.group}</b> : ${this.selected.dataset.description}`;

        }
    }" class="flex flex-col items-center justify-center w-full max-w-3xl mx-auto my-6">
        <div class="relative flex flex-col items-center w-full max-w-3xl p-4 pb-6 overflow-hidden border-gray-200 justify-items-stretch border-1 rounded-xl">
            <div class="w-full max-w-lg bg-contain vcolors-image aspect-video"></div>
            <div class="absolute text-xs font-normal vcolors-label top-4 left-4"></div>
        </div>
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
                <span class="vcolors-item w-12 h-12 border-white rounded-full border-4 outline-2 cursor-pointer hover:opacity-80 {{$cClass}}" style="background:{{ $c }};" title="{{$color['description']}} - {{$color['group']}}" :class="(selected == $el ? 'outline-theme' : 'outline-gray-200') @if($key > 4)+ (showAll ? '' : ' hidden')@endif" data-color="{{ $color['primaryHex'] }}" data-description="{{$color['description']}}" data-group="{{$color['group']}}" data-price="{{$color['basePrice']}}" data-image="{{ $color['colorImage']['image800'] ?? '' }}" @click="select"></span>
            @endforeach
            @if(count($colors) > 4)
                <span class="flex items-center justify-center w-12 h-12 border-4 border-white rounded-full cursor-pointer outline-2 outline-gray-100" x-show="!showAll" @click="showAll=true"><i class="icon icon-ellipsis-h text-2xl"></i></span>
            @endif
        </div>
    </div>
@endif
