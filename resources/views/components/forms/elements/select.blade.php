@props([
    "name" => "range_",
    "options" => [],
    "placeholder" => "Select option",
    "values" => array(),
    "multiple" => false,
])
{{-- {{ $multiple ? '' : 'open = false;' }} --}}
<div {{ $attributes->merge(['class' => 'h-11 border-gray-300 border-1 cursor-pointer relative select-none']) }} x-data="{
         open: false,
         selectedLabels: [],
         change() {
            this.selectedLabels = Array.from($el.querySelectorAll('input[name={{ $name }}]:checked')).map(input => input.dataset.label);
            {{ $multiple ? '' : 'this.open = false;' }}
         }
     }" x-init="change()" x-on:click.outside="open = false">
    <div class="flex items-center flex-1 h-full mx-4" x-on:click="open = ! open">
        <span class="flex-1" :class="selectedLabels.length ? '' : 'text-gray-400 italic'" x-text="selectedLabels.length ? selectedLabels.join(', ') : '{{ $placeholder }}'"></span>
        <span><span class="icon icon-chevron-down" :class="open ? 'icon-chevron-up' : 'icon-chevron-down'"></span></span>
    </div>
    <div x-show="open" x-cloak class="absolute z-10 w-full overflow-y-auto bg-white shadow-lg outline outline-gray-200 top-full max-h-40 min-h-30" @click.outside="open = false">
        @foreach ($options as $key => $option)
            <div class="px-3 border-b border-gray-100 active:bg-gray-50 hover:bg-gray-50">
                @if($multiple)
                    <x-forms.elements.checkbox name="{{ $name }}" value="{{ $option['value'] }}" :label="$option['name']" @change="change" class="flex py-2" :checked="is_array($values) && in_array($option['value'], $values)" />
                @else
                    <input type="radio" style="display:none!important;" id="id-{{ $name }}-{{ $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" data-label="{{ html_entity_decode(strip_tags($option['name'])) }}" @if($values == $option['value']) checked @endif @change="change">
                    <label class="inline-block w-full py-2 cursor-pointer select-none" for="id-{{ $name }}-{{ $option['value'] }}">{!! $option['name'] !!}</label>
                @endif
            </div>
        @endforeach
    </div>
</div>


