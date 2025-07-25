@props([
    "title" => null,
    "ref" => "customModal",
    "secure" => false,
])
<div {{ $attributes->merge(['class' => 'fixed flex top-0 left-0 right-0 bottom-0 h-screen w-screen z-100 md:items-center md:justify-center md:bg-black/50 md:p-8']) }} x-show="{{$ref}}Open" x-cloak>
    <div class="flex flex-col w-full h-full px-4 pb-4 overflow-auto bg-white modal-scroller md:max-w-lg md:m-auto md:h-auto md:shadow-lg md:max-h-full" @if(!$secure) x-on:click.outside="{{$ref}}Open=false" @endif>
        <div class="flex items-center justify-between py-4">
            <div class="text-2xl" data-area="title">
                @if($title) {{ $title }} @endif
            </div>
            <a href="javascript:void(0);" @click="{{$ref}}Open=!{{$ref}}Open"><i class="text-2xl icon icon-times"></i></a>
        </div>
        <div class="flex-1" data-area="content">
            {{ $slot }}
        </div>
    </div>
</div>
{{--bg-white flex flex-col px-4 w-full h-full--}}
