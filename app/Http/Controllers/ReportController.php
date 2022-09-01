<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    public function show()
    {
        return Inertia::render('App/Award/Report', ['award_complete' => Auth::user()->qsa_record->is_complete(), 'html' => view('record-sheet', ['app_preview' => true, 'award_complete' => Auth::user()->qsa_record->is_complete()])->render()]);
    }

    public function generate(Request $request)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->getOptions()->setChroot(public_path());
        $dompdf->loadHtml(view('record-sheet', ['app_preview' => false, 'award_complete' => Auth::user()->qsa_record->is_complete(), 'address' => $request->address, 'postcode' => $request->postcode, 'permanentAddress' => $request->permanent_address, 'phoneNumber' => $request->phone_number])->render());

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $dompdf->stream("myQSA " . Auth::user()->qsa_record->is_complete() ? 'Completion' : 'Progress' . " Report - $name.pdf", array("Attachment" => false));
    }
}
