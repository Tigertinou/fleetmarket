<div x-data="{
    selected: null,
    showAll: false,
    price : 0,
    vcolorsLabel : '',
    init() {
        this.select({ target : this.$el.querySelector('.vcolors-item') });
        this.preloadImages();
    },
    select (event) {
        this.selected = event.target;
        if(this.selected.dataset.image != '') {
            coverImage = this.selected.dataset.image;
        }
        this.vcolorsLabel = `${this.selected.dataset.description}`;
        if(this.selected.dataset.group!='' && this.selected.dataset.group != this.selected.dataset.description){
            this.vcolorsLabel =  `<b class='font-semibold'>${this.selected.dataset.group}</b><br>` + this.vcolorsLabel;
        }
        coverColorLabel = this.vcolorsLabel;
        this.price = this.selected.dataset.price;
        colorExternalSelected = this.selected.dataset.value;
        window.configurator.applyTotal();
    },
    preloadImages () {
        const images = Array.from(this.$el.querySelectorAll('.vcolors-item')).map(el => el.dataset.image);
        for (const image of images) {
            if(image && image != '') {
                const img = new Image();
                img.src = image;
            }
        }
    }
}" class="flex flex-col items-center justify-center w-full max-w-3xl mx-auto my-0">
    <div class="flex items-start w-full gap-4">
        <div class="flex-1 text-xs" x-html="vcolorsLabel"></div>
        <div class="px-2 py-1 text-xs font-bold border-2 rounded-lg" :class="price > 0 ? 'border-theme' : 'text-gray-400 border-gray-200'" x-text="'+' + price.toEuro()"></div>
    </div>
    <x-vehicles.colors-buttons :colors="$submodelColors['data']['external']"></x-vehicles.colors-selector>
</div>
