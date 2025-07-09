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
        colorInteriorSelected = this.selected.dataset.value;
        window.applyTotal();
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
    <div class="flex w-full gap-4 items-start">
        <div class="text-xs flex-1" x-html="vcolorsLabel"></div>
        <div class="font-bold text-xs border-2 border-theme py-1 px-2 rounded-lg" x-text="'+' + price.toEuro()"></div>
    </div>
    <x-vehicles.colors-buttons :colors="$submodelColors['data']['interior']"></x-vehicles.colors-selector>
</div>