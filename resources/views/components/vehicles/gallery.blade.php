@props([
    "images" => [],
])
@if(isset($images) && count($images) > 0)
    <div x-data="{
            expanded: false,
            init() {
                this.scroller = $el.children[0];
                this.scroller.scrollTo(0,0);
            },
            expand (event) {
                this.expanded = true;
            },
            collapse (event) {
                this.expanded = false;
            },
            back () {
                this.scroller.scrollBy({
                    left: -this.scroller.clientWidth,
                    behavior: 'smooth'
                });
            },
            next () {
                this.scroller.scrollBy({
                    left: this.scroller.clientWidth,
                    behavior: 'smooth'
                });
            }
        }" class="flex flex-col py-6" :class="expanded ? 'fixed bg-black text-white top-0 left-0 right-0 bottom-0 z-100 h-screen w-screen' : 'bg-gray-50'">
        <div class="flex-1 max-w-full overflow-auto cursor-pointer select-none snap-x snap-mandatory scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;" >
            <div class="flex flex-nowrap" :class="expanded ? 'w-screen h-full' : 'gap-3 px-4 h-120 md:h-96'" style="width:fit-content;">
                @foreach ($images as $image)
                    @if(isset($image['image800']))
                        <div class="relative h-full" :class="expanded ? 'w-screen flex items-center' : 'aspect-9/16 md:aspect-4/3 w-full'">
                            <a href="javascript:void(0)" class="absolute p-1 text-white bg-black rounded-full icon top-3 right-3" :class="expanded ? 'icon-times text-3xl fixed top-4 right-4' : 'icon-expand'" @click="( expanded ? collapse(event) : expand(event) ) "></a>
                            <img src="{{ $image['image800'] }}" loading="lazy" class="w-full h-full snap-center" @click="expand" :class="expanded ? 'object-contain max-h-[80vh]' : 'object-cover'">
                        </div>
                    @endif
                @endforeach
                <div>&nbsp;</div>
            </div>
        </div>
        <div class="flex items-center justify-center max-w-screen-xl gap-4 px-4 mx-auto mt-4">
            <div class="p-2 font-light rounded-full shadow-lg cursor-pointer text-md icon icon-chevron-left hover:opacity-90" @click="back" :class="expanded ? 'text-3xl' : 'bg-white'"></div>
            <div class="p-2 font-light rounded-full shadow-lg cursor-pointer text-md icon icon-chevron-right hover:opacity-90" @click="next" :class="expanded ? 'text-3xl' : 'bg-white'"></div>
        </div>
    </div>
@endif
