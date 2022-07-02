<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePresentationStatementRequest;
use App\Models\QsaRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PresentationController extends Controller
{
    public function show(Request $request): \Inertia\Response
    {
        $qsa_record = $request->user()->qsa_record;
        return Inertia::render("App/Award/Presentation", [
            "id" => $request->user()->id,
            "presentation_link" =>  $qsa_record->get_presentation_link(),
            "completed_by" => $qsa_record->presentation_name,
        ]);
    }

    public function show_statement_page(Request $request, string $presentation_key): \Inertia\Response
    {
        $qsa_record = QsaRecord::where('presentation_key', $presentation_key)->first();
        return Inertia::render("PresentationStatement", ['name' => $qsa_record->user->first_name, "completed" => $qsa_record->is_presentation_statement_complete()]);
    }

    public function store(SavePresentationStatementRequest $request, string $presentation_key): \Illuminate\Http\RedirectResponse
    {
        $qsa_record = QsaRecord::where('presentation_key', $presentation_key)->first();
        if ($qsa_record->is_presentation_statement_complete()) return Redirect::back()->withErrors("This statement has already been completed and can only be filled in once. Please email us to resolve this issue.");

        $validated = $request->validated();
        $qsa_record->presentation_name = $validated["name"];
        $qsa_record->presentation_email = $validated["email"];
        $qsa_record->presentation_date = $validated["date"];
        $qsa_record->presentation_statement = $validated["statement"];
        $qsa_record->save();

        return Redirect::back();
    }
}
