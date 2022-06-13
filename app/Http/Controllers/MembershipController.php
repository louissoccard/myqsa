<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMembershipRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class MembershipController extends Controller
{
    public function show(Request $request): \Inertia\Response
    {
        $qsa_record = $request->user()->qsa_record;
        return Inertia::render("App/Award/Membership", [
            "id" => $request->user()->id,
            "membership_record" => [
                "date_of_birth" => $qsa_record->date_of_birth,
                "explorers_start" => $qsa_record->explorers_start,
                "explorers_end" => $qsa_record->explorers_end,
                "network_start" => $qsa_record->network_start,
                "network_end" => $qsa_record->network_end,
            ],
        ]);
    }

    public function store(UpdateMembershipRequest $request, int $id)
    {
        $validated = $request->validated();

        $user = User::find($id);
        if ($user === null) abort(422);

        $qsa_record = $user->qsa_record;
        if (key_exists('date_of_birth', $validated)) $qsa_record->date_of_birth = $validated['date_of_birth'];
        if (key_exists('explorers_start', $validated)) $qsa_record->explorers_start = $validated['explorers_start'];
        if (key_exists('explorers_end', $validated)) $qsa_record->explorers_end = $validated['explorers_end'];
        if (key_exists('network_start', $validated)) $qsa_record->network_start = $validated['network_start'];
        if (key_exists('network_end', $validated)) $qsa_record->network_end = $validated['network_end'];
        $qsa_record->save();

        return Redirect::back();

    }
}
