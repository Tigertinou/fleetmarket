<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" class="min-h-screen" x-data="{
    isMobile: window.matchMedia('(max-width: 767px)').matches,
    init() {
      window.matchMedia('(max-width: 767px)').addEventListener('change', e => {
        this.isMobile = e.matches;
      });
    }
  }">
<head>
    <meta charset="utf-8">

    @stack(\App\Support\Stack::HEAD_START)

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">

    <title>{{ $title ?? 'FleetMarket' }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite([
        'resources/css/app.css',
        /* 'resources/sass/app.scss',  */
        'public/assets/fonts/fleetmarket.v1.1/styles.css',
        'resources/js/app.js'
        ])

    @stack(\App\Support\Stack::HEAD_END)
</head>
<body class="flex flex-col min-h-screen font-light">

    <x-layouts.header />

    <x-layouts.breadcrumb :$breadcrumb/>

    {{-- Contenu principal --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-layouts.footer />

</body>
</html>
