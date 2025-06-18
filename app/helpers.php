<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('lang')) {
    function lang(): string
    {
        return request()->route('lang') ?? app()->getLocale();
    }
}

if (!function_exists('localized_route')) {
    function localized_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        return route($name, array_merge(['lang' => lang()], $parameters), $absolute);
    }
}
