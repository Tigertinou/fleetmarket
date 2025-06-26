<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $lang = $request->route('lang') ?? config('app.locale');
        session(['locale' => $lang]);
        app()->setLocale($lang);

        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        match ($lang) {
            'fr' => $isWindows ? setlocale(LC_TIME, 'french') : setlocale(LC_TIME, 'fr_FR.UTF-8'),
            'nl' => $isWindows ? setlocale(LC_TIME, 'nld_nld') : setlocale(LC_TIME, 'nl_NL.UTF-8'),
            default => $isWindows ? setlocale(LC_TIME, 'english') : setlocale(LC_TIME, 'en_US.UTF-8'),
        };

        return $next($request);
    }
}
