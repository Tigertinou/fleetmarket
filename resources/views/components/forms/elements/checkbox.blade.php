@props([
    "label" => null,
    "name" => "inp_",
    "checked" => false,
    "disabled" => false,
    "value" => 1,
    "size" => 'md',
])
<div {{ $attributes->merge(['class' => 'checkbox']) }} style="font-size:{{ $size === 'lg' ? '1em' : '0.9em' }};">
    <div class="flex flex-1 items-center gap-2">
        <input type="checkbox" id="id-{{ $name }}-{{ $value }}" name="{{ $name }}" value="{{ $value }}" data-label="{{ html_entity_decode(strip_tags($label)) }}" @if($checked) checked @endif @if($disabled) disabled @endif>
        @if ($label)
            <label class="flex-1 mr-8 align-middle cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $label !!}</label>
        @elseif (!empty($slot))
            <label class="flex-1 mr-8 align-middle cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $slot !!}</label>
        @endif
    </div>
</div>
