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

if (!function_exists('minmax')) {
    /**
     * Retourne le min et max d'un tableau numérique.
     *
     * @param array $values Tableau de valeurs (int|float|null).
     * @return array|null [min, max] ou null si aucune valeur valide.
     */
    function minmax(array $values): ?array
    {
        $filtered = array_filter($values, fn($v) => is_numeric($v));
        if (empty($filtered)) {
            return null;
        }

        return [min($filtered), max($filtered)];
    }
}
