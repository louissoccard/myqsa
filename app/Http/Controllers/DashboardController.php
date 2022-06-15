<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $data = [];
        if ($request->user() !== null && $request->user()->hasRole('participant')) {
            $data['percentages'] = $request->user()->qsa_record->percentages();
        }

        return Inertia::render("App/Dashboard", $data);
    }
}
