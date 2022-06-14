<?php

namespace App\Http\Controllers;

use App\Http\Requests\IcvActivityRequest;
use App\Models\IcvActivity;
use App\Models\NightsAwayEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ICVListController extends Controller
{
    public function show(Request $request): \Inertia\Response
    {
        $qsa_record = $request->user()->qsa_record;
        return Inertia::render("App/Award/ICVList", [
            "id" => $request->user()->id,
            "icv_activities" => $qsa_record->icv_activities->map(fn($x) => [
                'id' => $x->id,
                'category' => $x->category,
                'start_date' => $x->start_date,
                'end_date' => $x->end_date,
                'description' => $x->description,
                'part_of_csa' => $x->part_of_csa,
            ]),
        ]);
    }

    public function store(IcvActivityRequest $request, int $id)
    {
        $validated = $request->validated();

        $user = User::find($id);
        if ($user === null) abort(422);

        $user->qsa_record->icv_activities()->create([
            'category' => $validated['category'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description'],
            'part_of_csa' => $validated['part_of_csa'],
        ]);

        return Redirect::back();

    }

    public function patch(IcvActivityRequest $request, int $id)
    {
        $validated = $request->validated();

        $icv_activity = IcvActivity::find($id);
        if ($icv_activity === null) abort(422);

        $icv_activity->category = $validated['category'];
        $icv_activity->start_date = $validated['start_date'];
        $icv_activity->end_date = $validated['end_date'];
        $icv_activity->description = $validated['description'];
        $icv_activity->part_of_csa = $validated['part_of_csa'];
        $icv_activity->save();

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        if (!IcvActivity::destroy($id)) abort(500);

        return Redirect::back();
    }
}
