@props([
    "color" => 'default',
])
@php
$def_class = 'block rounded-xl px-6 py-4';
switch ($color) {
    case 'default':
        $def_class .= " border-2 border-gray-200";
    break;
    case 'theme':
        $def_class .= " border-2 border-theme";
    break;
    case 'dark':
    case 'black':
        $def_class .= " bg-black text-white";
    break;
    case 'light':
    case 'gray':
        $def_class .= " bg-gray-200";
    break;
    default:
        $def_class .= " border-2 border-{$color}";
    break;
}
@endphp
<div {{ $attributes->merge(['class' => $def_class]) }} :class="active ? 'border-theme' : ''">
    {!! $slot !!}
</div>