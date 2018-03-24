<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanPaymentRequest extends FormRequest
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
        $currentYear = date('Y');
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^(\d{2}\s?){5}$/',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal' => 'required|numeric|regex:/^[0-9]{5}$/',
            'credit_card_number' => 'required|string|regex:/^[0-9]{16}$/',
            'exp_month' => 'required|string|regex:/^[0-9]{2}$/|between:1,12',
            'exp_year' => 'required|numeric|between:'.$currentYear.','.($currentYear + 25),
            'csc' => 'required|string|regex:/^[0-9]{3}$/'
        ];
    }
}
