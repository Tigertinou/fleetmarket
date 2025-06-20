@props([
    "label" => null,
    "name" => "inp_",
    "checked" => false,
    "disabled" => false,
    "value" => 1,
    "size" => 'md',
])
<div {{ $attributes->merge(['class' => 'radio']) }} style="font-size:{{ $size === 'lg' ? '1em' : '0.8em' }};">
    <input type="radio" id="id-{{ $name }}-{{ $value }}" name="{{ $name }}" value="{{ $value }}" label="{{ $label }}" @if($checked) checked @endif @if($disabled) disabled @endif>
    @if ($label)
        <label class="flex-1 py-2 pl-2 mr-8 cursor-pointer select-none" for="id-{{ $name }}-{{ $value }}">{!! $label !!}</label>
    @endif
</div>
