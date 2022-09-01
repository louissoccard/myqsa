<template>
    <!DOCTYPE html>
    <html lang="{{ app_locale }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>myQSA Completion Report - {{ first_name }} {{ last_name  }}</title>

        <!-- Margin -->
        <style>
            @page {
                margin: 75px;
            }
        </style>

        <!-- Fonts -->
        <style>
            p {
                font-size: 12px;
            }

            table {
                font-size: 14px;
            }

            /* nunito-sans-italic - latin */
            @font-face {
                font-family: 'Nunito Sans';
                font-style: italic;
                font-weight: 400;
                src: local(''),
                url('fonts/nunito-sans-v12-latin-italic.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
                url('fonts/nunito-sans-v12-latin-italic.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
            }
            /* nunito-sans-regular - latin */
            @font-face {
                font-family: 'Nunito Sans';
                font-style: normal;
                font-weight: 400;
                src: local(''),
                url('fonts/nunito-sans-v12-latin-regular.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
                url('fonts/nunito-sans-v12-latin-regular.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
            }
            /* nunito-sans-700 - latin */
            @font-face {
                font-family: 'Nunito Sans';
                font-style: normal;
                font-weight: bold;
                src: local(''),
                url('fonts/nunito-sans-v12-latin-700.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
                url('fonts/nunito-sans-v12-latin-700.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
            }
            /* nunito-sans-900 - latin */
            @font-face {
                font-family: 'Nunito Sans Black';
                font-style: normal;
                font-weight: bold;
                src: local(''),
                url('fonts/nunito-sans-v12-latin-900.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
                url('fonts/nunito-sans-v12-latin-900.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
            }
        </style>

        <!-- Styles -->
        <link rel="stylesheet" href="css/app.css">
        <style>
            .text-navy { color: #003982 }
            .font-black {
                font-weight: bold;
                font-family: 'Nunito Sans Black', sans-serif !important;
            }
        </style>
    </head>
    <body>
    <div class="text-black">
        <div class="mb-4">
            <div class="inline-block text-navy font-bold">
                <p class="text-3xl">Queen's Scout Award</p>
                <p class="text-2xl">Completion Report</p>
            </div>
            <span class="inline-block" style="width: 188px;"></span>
            <img src="logo.png" class="inline-block w-40" ref="logo"/>
        </div>

        <p class="text-justify">
            <strong class="font-bold">Data Protection:</strong> This form is used to collect information about a
            young
            person for the purpose of
            recording
            award completion. This is to be used by us at the Scouts
            HQ. As part of this form we collect personal
            data
            about a young person, which is required so that we can
            invite award holders to a day of celebration and
            achievement at Windsor Castle; to assess eligibility;
            and to monitor completions.
        </p>
        <p class="mt-2 mb-8">
            We take your personal data privacy seriously. The data you provide to us is securely stored on our
            electronic servers used by staff at the Scouts HQ. For further detail please visit our Data Protection
            Policy here. We will keep the basic data (award holders name, county and award completion date) we
            capture
            from this form permanently, so we have a historic record of award completions. The remaining data will
            be
            deleted three years after the award completion date. For further detail on our retention periods please
            visit our Data Protection Policy here.
        </p>

        <div class="mb-8">
            <h3 class="text-xl text-navy font-bold mb-2">Your Details</h3>
            <table class="w-full">
                <tbody>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Name</th>
                    <td class="p-4 border border-gray-200">{{ first_name }} {{ last_name }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Address</th>
                    <td class="p-4 border border-gray-200 whitespace-pre-wrap">{{ $address ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Is this your permanent address?</th>
                    <td class="p-4 border border-gray-200 whitespace-pre-wrap">{{ $permanentAddress ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Postcode</th>
                    <td class="p-4 border border-gray-200">{{ $postcode ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Phone Number</th>
                    <td class="p-4 border border-gray-200">{{ $phoneNumber ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Email Address</th>
                    <td class="p-4 border border-gray-200">{{ email }}</td>
                </tr>
                <tr>
                    <th class="text-left p-4 border border-gray-200 w-1/3">Date of Birth</th>
                    <td class="p-4 border border-gray-200">{{ date_of_birth }}</td>
                </tr>
                </tbody>
            </table>
        </div>

<!--        <div class="mb-8">-->
<!--            <h3 class="text-xl text-navy font-bold mb-2">Membership</h3>-->
<!--            <table class="w-full">-->
<!--                <tbody>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-56">Explorers Start Date</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->explorers_start_date }}</td>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-56">Explorers End Date</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->explorers_end_date }}</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-56">Network Start Date</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->network_start_date }}</td>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-56">Network End Date</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->network_end_date }}</td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->

<!--        <div class="mb-8">-->
<!--            <h3 class="text-xl text-navy font-bold mb-2">Nights Away</h3>-->
<!--            <table class="w-full">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200">Date</th>-->
<!--                    <th class="text-left p-4 border border-gray-200">Event / Location</th>-->
<!--                    <th class="text-left p-4 border border-gray-200">Number of Nights</th>-->
<!--                    <th class="text-left p-4 border border-gray-200">Camping</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                @foreach(Auth::user()->qsa_record->nights_away->all() as $night_away)-->
<!--                <tr>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $night_away->start_date }}</td>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $night_away->name }}</td>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $night_away->number_of_nights }}</td>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $night_away->camping ? 'Yes' : 'No' }}</td>-->
<!--                </tr>-->
<!--                @endforeach-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->

<!--        <div class="mb-8">-->
<!--            <h3 class="text-xl text-navy font-bold mb-2">International, Community and Values</h3>-->
<!--            <table class="w-full">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200">Category</th>-->
<!--                    <th class="text-left p-4 border border-gray-200">Activity</th>-->
<!--                    <th class="text-left p-4 border border-gray-200">Dates</th>-->
<!--                    <th class="text-left p-4 border border-gray-200">Completed for CSA?-->
<!--                    </th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                @foreach(Auth::user()->qsa_record->icv_activities->all() as $icv_activity)-->
<!--                <tr>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $icv_activity->category }}</td>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $icv_activity->description }}</td>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $icv_activity->start_date }}-->
<!--                        to {{ $icv_activity->end_date }}</td>-->
<!--                    <td class="text-left p-4 border border-gray-200">{{ $icv_activity->part_of_csa ? 'Yes' : 'No' }}</td>-->
<!--                </tr>-->
<!--                @endforeach-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->

<!--        <div class="mb-8">-->
<!--            <h3 class="text-xl text-navy font-bold mb-2">Duke of Edinburgh's Award</h3>-->
<!--            <table class="w-full">-->
<!--                <tbody>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-1/3">eDofE ID Number</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->edofe_number }}</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-1/3">Licenced Organisation</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->licenced_organisation }}</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <th class="text-left p-4 border border-gray-200 w-1/3">Date Gold DofE Completed</th>-->
<!--                    <td class="p-4 border border-gray-200">{{ Auth::user()->qsa_record->dofe_completion_date }}</td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->


        <p>Generated from myQSA by Hampshire Scouts
            at {{ generation_date }}</p>
    </div>
    </body>
    </html>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        app_locale: String,

        first_name: String,
        last_name: String,
        address: String,
        postcode: String,
        permanent_address: Boolean,
        phone_number: String,
        email: String,
        date_of_birth: String,


    }

})
</script>
