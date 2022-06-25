<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDofeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DofeController extends Controller
{
    public function show(Request $request): \Inertia\Response
    {
        $qsa_record = $request->user()->qsa_record;
        return Inertia::render("App/Award/DofE", [
            "dofe_organisation" => $qsa_record->dofe_organisation,
            "dofe_number" => $qsa_record->dofe_number,
            "dofe_completion" => $qsa_record->dofe_completion,
            "dofe_award" => [
                "volunteering" => $qsa_record->dofe_volunteering,
                "physical" => $qsa_record->dofe_physical,
                "skills" => $qsa_record->dofe_skills,
                "expedition" => $qsa_record->dofe_expedition,
                "residential" => $qsa_record->dofe_residential,
            ],
        ]);
    }

    public function store(UpdateDofeRequest $request, $id) {
        $validated = $request->validated();

        $user = User::find($id);
        if ($user === null) abort(422);

        $qsa_record = $user->qsa_record;
        if (key_exists('dofe_organisation', $validated)) $qsa_record->dofe_organisation = $validated['dofe_organisation'];
        if (key_exists('dofe_number', $validated)) $qsa_record->dofe_number = $validated['dofe_number'];
        if (key_exists('dofe_completion', $validated)) $qsa_record->dofe_completion = $validated['dofe_completion'];

        if (key_exists('dofe_volunteering', $validated)) $qsa_record->dofe_volunteering = $validated['dofe_volunteering'];
        if (key_exists('dofe_physical', $validated)) $qsa_record->dofe_physical = $validated['dofe_physical'];
        if (key_exists('dofe_skills', $validated)) $qsa_record->dofe_skills = $validated['dofe_skills'];
        if (key_exists('dofe_expedition', $validated)) $qsa_record->dofe_expedition = $validated['dofe_expedition'];
        if (key_exists('dofe_residential', $validated)) $qsa_record->dofe_residential = $validated['dofe_residential'];
        $qsa_record->save();

        return Redirect::back();
    }
}
