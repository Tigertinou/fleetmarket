<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* if (config('session.driver') === 'redis') {
            Session::setDefaultDriver('redis');
        }

        FilamentView::registerRenderHook(
            'head.start',
            fn () => '<meta name="locale" content="' . app()->getLocale() . '">'
        ); */
    }
}
