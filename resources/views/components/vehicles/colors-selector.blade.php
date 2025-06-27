@props([
    "colors" => [],
])
@if(isset($colors) && count($colors) > 0)
    <div x-data="{
        selected: null,
        init() {
            this.selected = this.$el.querySelector('.color-item');
        },
        select (event) {
            this.selected = event.target;
            console.log(this.selected);
        }
    }">
        <div class="flex flex-wrap items-center justify-center gap-2 p-2 mt-4 mb-2 ">
            @foreach ($colors as $color)
                @php
                    $c = $color['primaryHex'] ?? '#000000';
                    $cClass = '';
                    if(preg_match('/m[ée]tal/iu', $color['group']) === 1){
                        $cClass = 'color-metallic';
                    } else if(preg_match('/opa[qc]/iu', $color['group']) === 1) {
                        $cClass = 'color-opac';
                    }
                @endphp
                <span class="color-item w-12 h-12 border-white rounded-full border-3 outline-2 cursor-pointer {{$cClass}}" style="background:{{ $c }};" title="{{$color['description']}} - {{$color['group']}}" :class="selected == $el ? 'outline-theme' : 'outline-gray-200'" data-description="{{$color['description']}}" data-group="{{$color['group']}}" data-price="{{$color['basePrice']}}" @click="select"></span>
            @endforeach
        </div>
    </div>
@endif
