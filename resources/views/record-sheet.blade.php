<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>myQSA @if($award_complete)
            Completion
        @else
            Progress
        @endif Report - {{ Auth::user()->first_name }} {{ Auth::user()->last_name  }}</title>

    <!-- Margin -->
    <style>
        @page {
            margin: 75px;
        }
    </style>

    <!-- Fonts -->
    <style>
        table {
            font-size: 14px;
        }

        /* nunito-sans-900 - latin */
        @font-face {
            font-family: 'Nunito Sans Black';
            font-style: normal;
            font-weight: normal;
            src: local(''),
            @if($app_preview) url('/fonts/NunitoSans-Black.ttf') @else url('fonts/NunitoSans-Black.ttf') @endif format('truetype');
        }
    </style>

    <!-- Styles -->
    @if(!$app_preview)
        <link rel="stylesheet" href="css/app.css">
    @endif
    <style>
        .text-navy {
            color: #003982
        }

        .myqsa-font-black {
            font-family: 'Nunito Sans Black', sans-serif !important;
        }

        .page + .page {
            page-break-before: always;
        }
    </style>
</head>
<body>
<main>
    <div class="page">
        <div @if($app_preview) class="flex items-center justify-between text-navy mb-6" @endif>
            <div class="inline-block text-navy">
                <p class="text-3xl @if($app_preview) font-black @else myqsa-font-black @endif">Queen's Scout Award</p>
                <p class="text-2xl font-bold">@if($award_complete)
                        Completion
                    @else
                        Progress
                    @endif Report</p>
            </div>
            @if($app_preview)
                <img src="/logo.png" class="inline-block w-40" ref="logo"/>
            @else
                <span class="inline-block" style="width: 182px;"></span>
                <img src="logo.png" class="inline-block w-40" ref="logo"/>
            @endif
        </div>

        @if($award_complete)
            <p>Congratulations! You have now completed all parts of your Queen's Scout Award and you are ready to submit
                your
                award to Scout Headquarters. myQSA has automatically created the report below from the data you
                submitted to
                the
                system. If any of these details are incorrect, head back to the relevant page and update it (you may
                need to
                resubmit a section for approval depending on what you change). Then simply head back to the Generate
                Reports
                page
                and download the updated report.</p>
        @else
            <p>Well done on working towards your Queen's Scout Award. myQSA has automatically created the report below
                from the data you have entered so far. If any of these details are incorrect, head back to the relevant
                page and update it (you may need to
                resubmit a section for approval depending on what you change). Then simply head back to the Generate
                Reports
                page
                and download the updated report.</p>
        @endif

        <div class="mt-8 mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">Your Details</h3>
            <table class="w-full">
                <tbody>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Name</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</td>
                </tr>
                @if($award_complete)
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Address</th>
                    <td class="p-4 border border-gray-200 whitespace-pre-wrap"
                        id="report-address">{{ $address ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Postcode</th>
                    <td class="p-4 border border-gray-200" id="report-postcode">{{ $postcode ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Is this your permanent address?</th>
                    <td class="p-4 border border-gray-200 whitespace-pre-wrap"
                        id="report-permanent-address">{{ $permanentAddress ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Phone Number</th>
                    <td class="p-4 border border-gray-200" id="report-phone-number">{{ $phoneNumber ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Email Address</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Date of Birth</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->date_of_birth)->format('d/m/Y') }}</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="page">
        <div class="mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">Membership</h3>
            <table class="w-full">
                <tbody>
                <tr>
                    <th class="text-left p-4 border border-gray-200">Explorers Start Date</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->explorers_start_date)->format('d/m/Y') }}</td>
                    <th class="text-left p-4 border border-gray-200">Explorers End Date</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->explorers_end_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200">Network Start Date</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->network_start_date)->format('d/m/Y') }}</td>
                    <th class="text-left p-4 border border-gray-200">Network End Date</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->network_end_date)->format('d/m/Y') }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">Nights Away</h3>
            <table class="w-full">
                <thead>
                <tr>
                    <th class="text-left p-4 border border-gray-200">Date</th>
                    <th class="text-left p-4 border border-gray-200">Event / Location</th>
                    <th class="text-left p-4 border border-gray-200">Number of Nights</th>
                    <th class="text-left p-4 border border-gray-200">Camping</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->qsa_record->nights_away->all() as $night_away)
                    <tr>
                        <td class="text-left p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate($night_away->start_date)->format('d/m/Y') }}</td>
                        <td class="text-left p-4 border border-gray-200">{{ $night_away->name }}</td>
                        <td class="text-left p-4 border border-gray-200">{{ $night_away->number_of_nights }}</td>
                        <td class="text-left p-4 border border-gray-200">{{ $night_away->type === 'Camping' ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th class="text-left p-4 border border-gray-200">Total</th>
                    <th class="text-left p-4 border border-gray-200"></th>
                    <th class="text-left p-4 border border-gray-200">{{ Auth::user()->qsa_record->nights_away->sum('number_of_nights') }}</th>
                    <th class="text-left p-4 border border-gray-200">{{ Auth::user()->qsa_record->nights_away->where('type', 'Camping')->sum('number_of_nights') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="page">
        <div class="mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">International, Community and Values</h3>
            <table class="w-full">
                <thead>
                <tr>
                    <th class="text-left p-4 border border-gray-200">Category</th>
                    <th class="text-left p-4 border border-gray-200">Activity</th>
                    <th class="text-left p-4 border border-gray-200">Dates</th>
                    <th class="text-left p-4 border border-gray-200">Completed for CSA?
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->qsa_record->icv_activities->all() as $icv_activity)
                    <tr>
                        <td class="text-left p-4 border border-gray-200">{{ $icv_activity->category }}</td>
                        <td class="text-left p-4 border border-gray-200">{{ $icv_activity->description }}</td>
                        <td class="text-left p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate($icv_activity->start_date)->format('d/m/Y') }}
                            to {{ \Illuminate\Support\Facades\Date::createFromDate($icv_activity->end_date)->format('d/m/Y') }}</td>
                        <td class="text-left p-4 border border-gray-200">{{ $icv_activity->part_of_csa ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="page">
        <div class="mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">Duke of Edinburgh's Award</h3>
            <table class="w-full">
                <tbody>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">eDofE ID Number</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->dofe_number }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Licenced Organisation</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->dofe_organisation }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Date Gold DofE Completed</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->dofe_completion)->format('d/m/Y') }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">Presentation</h3>
            <table class="w-full">
                <tbody>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Commissioner's Name</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->presentation_name }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Commissioner's Email</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->presentation_email }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Presentation Date</th>
                    <td class="p-4 border border-gray-200">{{ \Illuminate\Support\Facades\Date::createFromDate(Auth::user()->qsa_record->presentation_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Commissioner's Statement</th>
                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->presentation_statement }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page @if ($app_preview) flex flex-col justify-between @endif">
        <div class="text-justify">
            <h4 class="text-3xl myqsa-font-black mb-2">Report Information</h4>

            <p class="text-sm">The information on this report was populated from data provided by the award participant
                and
                their
                supporters. We make every effort to ensure that data is correctly reproduced from the information held
                on
                myQSA and only information relating to this participant is included. The information in this report is
                only
                intended for use by the participant and the Scout Association. The participant may wish to share
                this report with other parties, but this is at their discretion. If any information on this report is
                incorrect or this report reaches unintended recipients, please contact Hampshire Scouts immediately by
                emailing
                myqsa@hampshirescouts.org.uk. This report was generated using myQSA by Hampshire Scouts
                on {{ (new DateTime("now", new DateTimeZone('Europe/London')))->format('d/m/Y') }}
                at {{ (new DateTime("now", new DateTimeZone('Europe/London')))->format('H:i') }}.</p>

            <h6 class="font-bold mt-4">Data Protection</h6>
            <p class="text-justify text-sm">
                This report contains information about a
                young
                person for the purpose of
                recording
                award completion. This is to be used by Scouts
                HQ. As part of this report we include personal
                data
                about a young person, which is required so that Scouts HQ can
                invite award holders to a day of celebration and
                achievement at Windsor Castle; to assess eligibility;
                and to monitor completions.
                <br/>
                <br/>
                The Scouts take your personal data privacy seriously. This data will be securely stored on their
                electronic servers used by staff at the Scouts HQ. For further detail please visit their Data Protection
                Policy <a href="https://scouts.org.uk/media/980616/Data-protection-Policy-v20-Oct-2018.pdf"
                          class="font-bold">here</a>. They will keep the basic data (award holders name, county and
                award completion date) they
                capture
                from this report permanently, so we have a historic record of award completions. The remaining data will
                be
                deleted three years after the award completion date. For further detail on their retention periods
                please
                visit their Data Protection Policy <a
                    href="https://scouts.org.uk/media/980616/Data-protection-Policy-v20-Oct-2018.pdf" class="font-bold">here</a>.
            </p></div>


        <footer class="text-center @if (!$app_preview) mt-72 @endif">
            <div>
                @if($app_preview)
                    <img src="/hampshire_scouts_logo.png" class="w-28 mx-auto"/>
                @else
                    <img src="hampshire_scouts_logo.png" class="w-28"/>
                @endif
            </div>
        </footer>
    </div>
</main>
</body>
</html>
