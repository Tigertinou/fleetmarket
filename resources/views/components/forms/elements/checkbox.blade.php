@props([
    "label" => null,
    "name" => "inp_",
    "checked" => false,
    "disabled" => false,
    "value" => 1,
    "size" => 'md',
])
<div {{ $attributes->merge(['class' => 'checkbox']) }} style="font-size:{{ $size === 'lg' ? '1em' : '0.8em' }};">
    <input type="checkbox" class="" id="id-{{ $name }}-{{ $value }}" name="{{ $name }}" value="{{ $value }}" data-label="{{ html_entity_decode(strip_tags($label)) }}" @if($checked) checked @endif @if($disabled) disabled @endif>
    @if ($label)
        <label class="flex-1 pl-2 mr-8 align-middle cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $label !!}</label>
    @endif
</div>
