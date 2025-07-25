<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lang')) {
            $query->where('lang', $request->lang);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', "%{$request->search}%")
                  ->orWhere('lastname', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('ref', 'like', "%{$request->search}%");
            });
        }

        $leads = $query
            ->orderByDesc('created_at')
            ->paginate($request->get('per_page', 15));

        return response()->json($leads);
    }
}

