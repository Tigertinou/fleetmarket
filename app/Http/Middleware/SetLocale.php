<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('lang', config('app.locale'));
        session(['locale' => $locale]);
        app()->setLocale($locale);

        match ($locale) {
            'fr' => stripos(PHP_OS_FAMILY, 'Windows') ? setlocale(LC_TIME, 'fr_FR.UTF-8') : setlocale(LC_TIME, 'french'),
            'nl' => stripos(PHP_OS_FAMILY, 'Windows') ? setlocale(LC_TIME, 'nl_NL.UTF-8') : setlocale(LC_TIME, 'nld_nld'),
            default => stripos(PHP_OS_FAMILY, 'Windows') ? setlocale(LC_TIME, 'en_US.UTF-8') : setlocale(LC_TIME, 'english'),
        };

        return $next($request);
    }
}
