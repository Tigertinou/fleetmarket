<div>

    <select class="hidden">
        <option value="0">Select option</option>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>

    <div {{ $attributes->merge(['class' => 'h-11 border-gray-300 border-1 cursor-pointer relative select-none']) }} x-data="{ open : false }">
        <div class="flex items-center flex-1 h-full mx-4" x-on:click="open = ! open">
            <span class="flex-1">placeholder</span>
            <span><span class="icon icon-chevron-down" :class="open ? 'icon-chevron-up' : 'icon-chevron-down'"></span></span>
        </div>
        <div x-show="open" x-cloak class="absolute z-10 w-full overflow-y-auto bg-white border border-gray-200 shadow-lg top-full max-h-40 min-h-30" @click.outside="open = false">
            <div class="p-2 border-b border-gray-100"><input type="checkbox"> option 1</div>
            <div class="p-2 border-b border-gray-100">option 2</div>
            <div class="p-2 border-b border-gray-100">option 3</div>
            <div class="p-2 border-b border-gray-100">option 4</div>
            <div class="p-2 border-b border-gray-100">option 4</div>
            <div class="p-2 border-b border-gray-100">option 4</div>
            <div class="p-2 border-b border-gray-100">option 4</div>
            <div class="p-2 border-b border-gray-100">option 4</div>
            <div class="p-2 border-b border-gray-100">option 4</div>
        </div>
    </div>
</div>
