@props([
    "label" => null,
    "name" => "inp_",
    "checked" => false,
    "disabled" => false,
    "value" => 1,
    "size" => 'md',
])
<div {{ $attributes->merge(['class' => 'checkbox']) }} style="font-size:{{ $size === 'sm' ? '0.8em' : '1em' }};">
    <input type="checkbox" class="my-2" id="id-{{ $name }}-{{ $value }}" name="{{ $name }}" value="{{ $value }}" data-label="{{ html_entity_decode(strip_tags($label)) }}" @if($checked) checked @endif @if($disabled) disabled @endif>
    @if ($label)
        <label class="flex-1 py-2 pl-3 mr-8 cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $label !!}</label>
    @endif
</div>
