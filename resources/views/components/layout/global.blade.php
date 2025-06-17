<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" class="min-h-screen bg-neutral-50">
<head>
    <meta charset="utf-8">
    @stack(\App\Support\Stack::HEAD_START)
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">

    <title>{{ $title ?? 'FleetMarket' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack(\App\Support\Stack::HEAD_END)
</head>
<body class="bg-gray-50 text-gray-900">

    {{-- Header --}}
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $title ?? 'Titre par défaut' }}
            </h1>
        </div>
    </header>

    {{-- Contenu principal --}}
    <main class="min-h-screen py-8 px-4">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-100 text-center text-sm text-gray-500 py-4">
        &copy; {{ date('Y') }} MonApplication. Tous droits réservés.
    </footer>

</body>
</html>
