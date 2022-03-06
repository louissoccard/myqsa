<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AwardController extends Controller
{
    public function show(Request $request) {
        return Inertia::render("App/Award");
    }

}
