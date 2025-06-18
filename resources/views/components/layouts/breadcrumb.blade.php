@if (isset($breadcrumbs) && is_array($breadcrumbs))
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-screen-xl px-4 py-2 mx-auto">
            <nav class="flex items-center space-x-4">
                <a href="{{ localized_route('pages.home') }}" class="text-sm text-gray-600 hover:text-theme">Accueil</a>
                @foreach ($breadcrumbs as $breadcrumb)
                    <span class="text-sm text-gray-400">/</span>
                    <a href="{{ $breadcrumb['url'] ?? '#' }}" class="text-sm text-gray-600 hover:text-theme">{{ $breadcrumb['label'] }}</a>
                @endforeach
            </nav>
        </div>
    </div>
@endif
