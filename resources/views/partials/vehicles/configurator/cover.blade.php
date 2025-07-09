<div class="relative flex flex-col items-center w-full pb-2 overflow-hidden border-gray-200 justify-items-stretch border-1 rounded-xl">
    {{-- <img src="{{ $make['logo'] }}" class="absolute w-10 md:w-24 md:order-1 right-4 top-4" alt="{{ $vehicle['model']['makeName'] }} logo"> --}}
    <div class="self-center w-full max-w-lg transition-all bg-center bg-no-repeat bg-contain vcolors-image" :class="onStickyCover ? 'aspect-16/6' : 'aspect-16/9'"></div>
    <div class="absolute text-xs font-normal text-center vcolors-label top-3 left-4 right-4"></div>
    {{-- <img src="{{ $submodeColors['data']['external'][0]['colorImage']['image800'] }}" class="object-cover w-full h-full"> --}}
</div>
