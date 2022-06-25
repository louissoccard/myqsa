<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDofeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dofe_organisation' => ['string', 'nullable'],
            'dofe_number' => ['integer', 'nullable'],
            'dofe_completion' => ['date', 'date_format:Y-m-d', 'nullable'],

            'dofe_volunteering' => ['string', 'in:Not Started,In Progress,Complete'],
            'dofe_skills' => ['string', 'in:Not Started,In Progress,Complete'],
            'dofe_physical' => ['string', 'in:Not Started,In Progress,Complete'],
            'dofe_expedition' => ['string', 'in:Not Started,In Progress,Complete'],
            'dofe_residential' => ['string', 'in:Not Started,In Progress,Complete'],
        ];
    }
}
