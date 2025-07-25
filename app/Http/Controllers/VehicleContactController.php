<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Lead;
class VehicleContactController extends Controller
{
    /* public function __invoke(Request $request)
    {
        $locale = app()->getLocale();

        return view('pages.vehicles.contact');
    } */

    public function partialContactForm(Request $request)
    {

        $params = $request->query();
        $options = [];

        return response(view('partials.vehicles.contact.form'));

    }

    public function storeContactForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lang' => 'nullable|string|in:fr,nl,en',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'postcode' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:1000',
            'make' => 'nullable|array',
            'model' => 'nullable|array',
            'version' => 'nullable|array',
            'data' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $lead = new Lead();
        $lead->ref = strtoupper(Str::random(8));
        $lead->lang = $data['lang'] ?? app()->getLocale();
        $lead->firstname = $data['firstname'];
        $lead->lastname = $data['lastname'];
        $lead->email = $data['email'] ?? null;
        $lead->phone = $data['phone'] ?? null;
        $lead->postcode = $data['postcode'] ?? null;
        $lead->message = $data['message'] ?? null;
        $lead->make_id = $data['make']['id'] ?? null;
        $lead->model_id = $data['model']['id'] ?? null;
        $lead->version_id = $data['version']['id'] ?? null;
        $lead->status = 'new';
        $lead->data = $request->except([
            'firstname',
            'lastname',
            'email',
            'phone',
            'postcode',
            'message',
            'lang'
        ]);

        $lead->save();

        return response()->json($data,200);
    }
}
