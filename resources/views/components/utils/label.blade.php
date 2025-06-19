@props([
    "label" => null,
    "color" => 'dark',
    "size" => 'xs',
    "url" => "javascript:void(0);",
])
@php
$def_class = 'inline-block rounded-md ';
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
        $def_class .= " px-3 py-1 text-xs";
    break;
    case 'sm':
        $def_class .= " px-4 py-1.5 text-sm";
    break;
    default:
        $def_class .= " px-6 py-2";
    break;
}
@endphp
<span {{ $attributes->merge(['class' => $def_class]) }}>{{ $label }}</span>
