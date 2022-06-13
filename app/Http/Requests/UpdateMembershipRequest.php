<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateMembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return Auth::user()->id === $id;
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
            'date_of_birth' => ['date', 'date_format:Y-m-d', 'nullable', 'after:-25years', 'before:-16years'],
            'explorers_start' => ['date', 'date_format:Y-m-d', 'nullable', 'after:-25years', 'before:9years'],
            'explorers_end' => ['date', 'date_format:Y-m-d', 'nullable', 'after:-25years', 'before:9years'],
            'network_start' => ['date', 'date_format:Y-m-d', 'nullable', 'after:-25years', 'before:9years'],
            'network_end' => ['date', 'date_format:Y-m-d', 'nullable', 'after:-25years', 'before:9years'],
        ];
    }
}
