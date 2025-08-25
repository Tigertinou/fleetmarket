@props([
    'label' => null,
    'name' => 'inp_',
    'checked' => false,
    'disabled' => false,
    'value' => 1,
    'size' => 'md',
    'xInit' => null,
    'xEffect' => null,
    'control' => null,
])

@php
    $sizeClasses = match($size) {
        'lg' => ['track' => 'w-13 h-8', 'thumb' => 'h-6 w-6', 'translate' => 'translate-x-6'],
        'sm' => ['track' => 'w-8 h-5', 'thumb' => 'h-3 w-3', 'translate' => 'translate-x-4'],
        default => ['track' => 'w-10 h-6', 'thumb' => 'h-4 w-4', 'translate' => 'translate-x-5'],
    };
@endphp

<div x-data="{ toggled: @js($checked) }" 
{!! $xInit ? 'x-init="' . $xInit . '"' : '' !!} 
{!! $xEffect ? 'x-effect="' . $xEffect . '"' : '' !!} 
{{ $attributes->merge(['class' => 'flex items-center cursor-pointer gap-2' . ($disabled ? 'opacity-50 pointer-events-none' : '')]) }}>
    <input type="checkbox" name="{{ $name }}" :value="toggled ? '{{ $value }}' : '0'" id="id-{{ $name }}-{{ $value }}" @if($checked) checked @endif @if($disabled) disabled @endif
           style="display: none;" x-model="toggled" class="form-switch" />

    <button
        type="button"
        @click="toggled = !toggled"
        :aria-expanded="toggled.toString()"
        @if($control) aria-controls="{{ $control }}" @endif
        :class="toggled ? 'bg-theme' : 'bg-gray-300'"
        class="relative inline-flex items-center cursor-pointer {{ $sizeClasses['track'] }} rounded-full transition-colors duration-300 focus:outline-none"
    >
        <span
            :class="toggled ? '{{ $sizeClasses['translate'] }}' : 'translate-x-1'"
            class="inline-block {{ $sizeClasses['thumb'] }} transform rounded-full bg-white transition-transform duration-300"
        ></span>
    </button>

    @if($label)
        <label class="select-none cursor-pointer" for="id-{{ $name }}-{{ $value }}">{!! $label !!}</label>
    @endif
</div>
