@props([
    "label" => null,
    "name" => null,
    "disabled" => false,
    "size" => 'md',
    "color" => 'dark',
    "url" => "javascript:void(0);",
    "icon" => null,
    "rIcon" => null,
])
@php
$def_class = 'inline-block rounded-full hover:opacity-90 transition-all duration-200 ease-in-out';
switch ($color) {
    case 'theme':
    case 'theme-2':
        $def_class .= " bg-{$color} text-white";
    break;
    case 'dark':
    case 'black':
        $def_class .= " bg-black text-white";
    break;
    case 'light':
    case 'gray':
        $def_class .= " bg-gray-200 font-normal";
    break;
    default:
        $def_class .= " bg-{$color} text-white";
    break;
}
$def_class .= " bg-{$color}";
switch ($size) {
    case 'xs':
        $def_class .= " px-4 py-1 text-xs";
    break;
    case 'sm':
        $def_class .= " px-5 py-1.5 text-sm";
    break;
    default:
        $def_class .= " px-6 py-2";
    break;
}
@endphp
<a href="{{ $url }}" {{ $attributes->merge(['class' => $def_class]) }}>
    @if($icon ?? false)
        <span class="icon {{ $icon }} inline-block align-middle mr-1 -ml-2"></span>
    @endif
    {!! $label !!}
    @if($rIcon ?? false)
        <span class="icon {{ $rIcon }} inline-block align-middle ml-1 -mr-2"></span>
    @endif
</a>

