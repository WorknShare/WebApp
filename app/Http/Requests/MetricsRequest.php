<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetricsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->ajax();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start'
        ];
    }
}
