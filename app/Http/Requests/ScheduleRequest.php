<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'id_site' => 'required|integer|min:1',
            'day' => 'required|integer|min:0|max:6',
            'hour_opening' => 'required|date_format:H:i',
            'hour_closing' => 'required|date_format:H:i|after:hour_opening',
        ];
    }
}
