<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleSearchController;
use App\Http\Controllers\VehicleDetailModelController;
use App\Http\Controllers\VehicleDetailSubmodelController;
use App\Http\Controllers\VehicleConfiguratorController;
use App\Http\Controllers\VehicleContactController;
use App\Http\Middleware\SetLocale;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

Route::redirect('/', '/fr/');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => 'fr|nl|en'],'middleware' => [SetLocale::class]], function () {
    Route::get('/', function () { return view('pages.home'); })->name('pages.home');

    Route::get('/privacy-policy', function () { return view('pages.privacy-policy'); })->name('pages.privacy-policy');
    Route::get('/legals', function () { return view('pages.legals'); })->name('pages.legals');
    Route::get('/terms', function () { return view('pages.terms'); })->name('pages.terms');
    Route::get('/contact', function () { return view('pages.contact'); })->name('pages.contact');
    Route::get('/cookies', function () { return view('pages.cookies'); })->name('pages.cookies');
    Route::get('/guides', function () { return view('pages.guides'); })->name('pages.guides');
    Route::get('/about', function () { return view('pages.about'); })->name('pages.about');
    Route::get('/how-it-works', function () { return view('pages.how-it-works'); })->name('pages.how-it-works');

    Route::get('/recherche',VehicleSearchController::class)->name('pages.vehicles.search');

    Route::get('/compare', function () {
        return view('pages.vehicles.compare');
    })->name('pages.vehicles.compare');

    Route::get('/elements', function () {
        return view('pages.elements');
    })->name('pages.elements');

    Route::prefix('/partials')->group(function () {
        Route::get('/vehicles/search/results', [VehicleSearchController::class, 'partialResult'])->name('vehicles.search.partial');
        Route::get('/vehicles/configurator/options', [VehicleConfiguratorController::class, 'partialOptions'])->name('vehicles.configurator.options.partial');

        Route::get('/vehicles/contact/form', [VehicleContactController::class, 'partialContactForm'])->name('vehicles.contact.form.partial');
        Route::post('/vehicles/contact/store', [VehicleContactController::class, 'storeContactForm'])->name('vehicles.contact.store');
        Route::get('/vehicles/comparator/modal', function () { return view('partials.vehicles.comparator.modal'); })->name('vehicles.comparator.modal.partial');
    });

    Route::get('/{make:slug}/{model:slug}/configurator', VehicleConfiguratorController::class)->name('pages.vehicles.configurator');

    Route::get('/{make:slug}/{model:slug}/{submodel:slug}', VehicleDetailSubmodelController::class)->name('pages.vehicles.detail.submodel');

    Route::get('/{make:slug}/{model:slug}', VehicleDetailModelController::class)->name('pages.vehicles.detail.model');

    Route::get('/{make:slug}', VehicleSearchController::class, 'byMake')->name('pages.vehicles.search.make');

    // Route::get('/{make:slug}/{model:slug}/{version:slug}', [VehicleController::class, 'showVersion'])->name('pages.vehicles.version');

    Route::fallback(function () {
        abort(404);
    });

});


Route::get('/force-login', function () {
    $user = User::first(); // ou User::find(1)

    Auth::login($user);

    return redirect('/session-check');
});

Route::get('/session-check', function () {
    return [
        'auth_user' => auth()->user(),
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'cookie' => request()->cookie(config('session.cookie')),
    ];
})->name('session.check')->middleware('web');

Route::get('/debug-session', function () {
    $sessionId = session()->getId();
    $key = 'laravel_database_' . $sessionId;
    $exists = Redis::exists($key);
    $raw = $exists ? Redis::get($key) : null;

    return [
        'cookie' => request()->cookie('laravel_session'),
        'session_id' => $sessionId,
        'session_exists_in_redis' => $exists,
        'session_data' => session()->all(),
        'redis_raw' => $raw,
        'all_keys' => Redis::keys('*'),
        'session_driver' => config('session.driver'),
        'connection_connection' => config('session.connection'),
        'session_prefix' => config('session.prefix'),

    ];
});

Route::get('/test-session', function () {
    if (! session()->has('counter')) {
        session(['counter' => 1]);
    } else {
        session(['counter' => session('counter') + 1]);
    }

    return session()->all();
});
# Auth::routes();
