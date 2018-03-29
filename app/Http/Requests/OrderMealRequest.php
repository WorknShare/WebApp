<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderMealRequest extends FormRequest
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
          'id_client' => 'required|integer|min:1',
          'id_site' => 'required|integer|min:1',
          'date' => 'required|date_format:Y-m-d|after_datetime:hour,now',
          'hour' => 'required|date_format:H:i',
        ];
    }
}
