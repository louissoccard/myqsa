<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NightsAwayEventRequest extends FormRequest
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
            'name' => ['present', 'filled', 'string', 'max:255'],
            'start_date' => ['present', 'filled', 'date', 'date_format:Y-m-d'],
            'type' => ['present', 'filled', 'string', 'in:Camping,Indoors'],
            'number_of_nights' => ['present', 'filled', 'integer', 'gt:0', 'lte:18'],
        ];
    }
}
