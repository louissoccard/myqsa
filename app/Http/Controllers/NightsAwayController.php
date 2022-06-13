<?php

namespace App\Http\Controllers;

use App\Http\Requests\NightsAwayEventRequest;
use App\Models\NightsAwayEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NightsAwayController extends Controller
{
    public function show(Request $request): \Inertia\Response
    {
        $qsa_record = $request->user()->qsa_record;
        return Inertia::render("App/Award/NightsAway", [
            "id" => $request->user()->id,
            "nights_away" => $qsa_record->nights_away->map(fn($x) => [
                'id' => $x->id,
                'name' => $x->name,
                'start_date' => $x->start_date,
                'type' => ucfirst($x->type),
                'number_of_nights' => $x->number_of_nights,
            ]),
        ]);
    }

    public function store(NightsAwayEventRequest $request, int $id)
    {
        $validated = $request->validated();

        $user = User::find($id);
        if ($user === null) abort(422);

        $user->qsa_record->nights_away()->create([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'type' => $validated['type'],
            'number_of_nights' => $validated['number_of_nights'],
        ]);

        return Redirect::back();

    }

    public function patch(NightsAwayEventRequest $request, int $id)
    {
        $validated = $request->validated();

        $night_away = NightsAwayEvent::find($id);
        if ($night_away === null) abort(422);

        $night_away->name = $validated['name'];
        $night_away->start_date = $validated['start_date'];
        $night_away->type = $validated['type'];
        $night_away->number_of_nights = $validated['number_of_nights'];
        $night_away->save();

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        if (!NightsAwayEvent::destroy($id)) abort(500);

        return Redirect::back();
    }
}
