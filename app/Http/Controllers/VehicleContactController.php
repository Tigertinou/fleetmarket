<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilterFacet;
use App\Enums\FilterEnum;

class VehicleContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $locale = app()->getLocale();

        return view('pages.vehicles.contact');
    }

    public function partialContactForm(Request $request)
    {

        $params = $request->query();
        $options = [];

        return response(view('partials.vehicles.contact.form'));

    }
}
