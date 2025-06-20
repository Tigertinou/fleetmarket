@if (isset($breadcrumb) && is_array($breadcrumb) && !empty($breadcrumb))
    <div class="bg-white border-b border-gray-200 text-gray-600">
        <div class="max-w-screen-xl px-4 py-2 mx-auto">
            <nav class="flex items-center space-x-2">
                {{--<a href="{{ localized_route('pages.home') }}" class="text-sm text-gray-600 hover:text-theme">Accueil</a>--}}
                @foreach ($breadcrumb as $key => $item )
                    @if($key > 0)
                        <span class="text-[10px] icon icon-chevron-right font-extrabold"></span>
                    @endif
                    <a href="{{ $item['url'] ?? '#' }}" class="text-sm hover:text-theme {{ $item['class'] ?? '' }}">{!! $item['label'] !!}</a>
                @endforeach
            </nav>
        </div>
    </div>
@endif
