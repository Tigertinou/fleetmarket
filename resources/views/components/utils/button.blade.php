@props([
    "label" => null,
    "name" => null,
    "disabled" => false,
    "size" => 'md',
    "color" => 'dark',
    "url" => "javascript:void(0);",
    "icon" => null,
    "rIcon" => null,
    "align" => ''
])
@php
$def_class = 'inline-block rounded-full hover:opacity-90 transition-all duration-200 ease-in-out text-center';
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
        $def_class .= " bg-gray-100 font-normal";
    break;
    case 'bordered':
        $def_class .= " border-1 border-gray-200 font-normal";
    break;
    default:
        $def_class .= " bg-{$color} text-white";
    break;
}
$def_class .= " bg-{$color}";
$def_class_icon = " mr-1 -ml-2";
$def_class_r_icon = " ml-1 -mr-2";
switch ($size) {
    case 'xs':
        $def_class .= " px-3 py-1 text-xs";
        $def_class_icon = " mr-1 -ml-1";
        $def_class_r_icon = " ml-1 -mr-2";
    break;
    case 'sm':
        $def_class .= " px-4 py-2 text-xs";
        $def_class_icon = " mr-1 -ml-1";
        $def_class_r_icon = " ml-1 -mr-2";
    break;
    case 'md':
        $def_class .= " px-6 py-3 text-sm";
        $def_class_icon = " mr-2 -ml-3";
        $def_class_r_icon = " ml-2 -mr-3";
    break;
    case 'lg':
        $def_class .= " px-8 py-3 text-md";
        $def_class_icon = " mr-2 -ml-4";
        $def_class_r_icon = " ml-2 -mr-5";
    break;
    default:
        $def_class .= " px-6 py-3 text-sm";
        $def_class_icon = " mr-2 -ml-3";
        $def_class_r_icon = " ml-2 -mr-3";
    break;
}
@endphp
<a href="{{ $url }}" {{ $attributes->merge(['class' => $def_class]) }}>
    <div class="flex items-center justify-center">
        @if($icon ?? false)
            <div class="align-middle {{ $def_class_icon }}"><i class="icon {{ $icon }} inline-block"></i></div>
        @endif
        <div class="{{ $align == 'center' ? 'flex-1' : ''}} {{ $align == 'left' ? 'flex-1 text-left' : ''}} {{ $align == 'right' ? 'flex-1 text-right' : ''}}">{!! $label !!}</div>
        @if($rIcon ?? false)
            <div class="align-middle {{ $def_class_r_icon }}"><i class="icon {{ $rIcon }} inline-block"></i></div>
        @endif
    </div>
</a>

