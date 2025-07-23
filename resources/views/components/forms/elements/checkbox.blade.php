@props([
    "label" => null,
    "name" => "inp_",
    "checked" => false,
    "disabled" => false,
    "required" => false,
    "value" => 1,
    "size" => 'md',
    "position" => 'center',
])
<div {{ $attributes->merge(['class' => 'checkbox']) }} style="font-size:{{ $size === 'lg' ? '1em' : ($size === 'sm' ? '0.8em' : '0.9em') }};">
    <div class="flex items-{{ $position }} flex-1 gap-2">
        <input type="checkbox" id="id-{{ $name }}-{{ $value }}" name="{{ $name }}" value="{{ $value }}" data-label="{{ html_entity_decode(strip_tags($label)) }}" @if($checked) checked @endif @if($disabled) disabled @endif @if($required) required @endif style="font-size:{{ $size === 'sm' ? '0.8em' : '1em' }}">
        @if ($label)
            <label class="flex-1 mr-8 align-middle cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $label !!}</label>
        @elseif (!empty($slot))
            <label class="flex-1 mr-8 align-middle cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $slot !!}</label>
        @endif
    </div>
</div>
