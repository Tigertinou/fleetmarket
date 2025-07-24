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

if (!function_exists('__tl')) {
    if (!function_exists('__tl')) {
        function __tl(string $key, array $replace = [], ?string $fallback = null): string
        {
            static $translationsCache = [];
            $locales = ['fr', 'nl', 'en'];
            $currentLocale = app()->getLocale();

            $translation = __($key);

            if ($translation !== $key && !empty($replace)) {
                foreach ($replace as $k => $v) {
                    $translation = str_replace(":$k", $v, $translation);
                }
            }

            if ($translation !== $key) {
                return $translation;
            }

            // Si aucune traduction trouvée
            $defaultValue = $fallback ?? $key;

            // On applique aussi les remplacements au fallback
            foreach ($replace as $k => $v) {
                $defaultValue = str_replace(":$k", $v, $defaultValue);
            }

            // On ajoute la clé brute à chaque fichier JSON si elle n’existe pas
            foreach ($locales as $locale) {
                $path = resource_path("lang/{$locale}.json");

                if (!isset($translationsCache[$locale])) {
                    $translationsCache[$locale] = file_exists($path)
                        ? json_decode(file_get_contents($path), true)
                        : [];
                }

                if (!array_key_exists($key, $translationsCache[$locale])) {
                    $translationsCache[$locale][$key] = $fallback ?? $key;
                    file_put_contents(
                        $path,
                        json_encode($translationsCache[$locale], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                    );
                }
            }

            return $defaultValue;
        }

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
