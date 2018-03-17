<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
            'order_meal' => 'boolean',
            'reserve' => 'boolean',
            'advantages' => 'required_without_all:order_meal,reserve|array',
            'advantages.*' => 'integer|exists:plan_advantages,id_plan_advantage'
        ];
    }
}
