<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(Request $request) {
        return Inertia::render("App/Dashboard", [
            'percentages' => $request->user()->qsa_record->percentages(),
            'notes' => $request->user()->notes,
        ]);
    }

    public function save_notes(Request $request) {
        $request->user()->notes = $request->input('notes');
        $request->user()->save();

        return Redirect::route('dashboard');
    }
}
