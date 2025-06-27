@props([
    "colors" => [],
])
@if(isset($colors) && count($colors) > 0)
    <div x-data="{
        selected: null,
        showAll: false,
        init() {
            this.select({ target : this.$el.querySelector('.vcolors-item') });
        },
        select (event) {
            this.selected = event.target;
            if(this.selected.dataset.image != '') {
                $el.querySelector('.vcolors-image').style.backgroundImage = 'url(' + this.selected.dataset.image + ')';
            }
            $el.querySelector('.vcolors-label').innerHTML = `<b>${this.selected.dataset.group}</b> : ${this.selected.dataset.description}`;

        }
    }" class="flex flex-col items-center justify-center w-full max-w-3xl mx-auto my-0">
        <div class="relative flex flex-col items-center w-full max-w-3xl p-4 pb-6 overflow-hidden border-gray-200 justify-items-stretch border-1 rounded-xl">
            <div class="w-full max-w-lg bg-contain vcolors-image aspect-video"></div>
            <div class="absolute text-xs font-normal vcolors-label top-4 left-4"></div>
        </div>
        <x-vehicles.colors-buttons :colors="$colors" />
    </div>
@endif
