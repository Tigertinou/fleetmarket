@props([
    "title" => null,
    "ref" => "customModal",
])
<div {{ $attributes->merge(['class' => 'fixed flex top-0 left-0 right-0 bottom-0 h-screen w-screen z-100 md:items-center md:justify-center md:bg-black/50 md:p-8']) }} x-show="{{$ref}}Open" x-cloak>
    <div class="bg-white flex flex-col px-4 pb-4 w-full h-full overflow-auto md:max-w-lg md:m-auto md:h-auto md:shadow-lg md:max-h-full" x-on:click.outside="{{$ref}}Open=false">
        <div class="flex items-center justify-between py-4">
            <div class="text-2xl">
                @if($title) {{ $title }} @endif
            </div>
            <a href="javascript:void(0);" @click="{{$ref}}Open=!{{$ref}}Open"><i class="text-2xl icon icon-times"></i></a>
        </div>
        <div class="flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
{{--bg-white flex flex-col px-4 w-full h-full--}}