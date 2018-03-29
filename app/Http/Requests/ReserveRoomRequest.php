<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRoomRequest extends FormRequest
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
          'id_room' => 'required|integer|min:1',
          'date' => 'required|date_format:Y-m-d|after:tomorrow|after_datetime:hour_start,now',
          'hour_start' => 'required|date_format:H:i',
          'hour_end' => 'required|date_format:H:i|after:hour_start',
          'equipments' => 'array',
          'equipments.*' => 'integer|exists:equipment,id_equipment'
        ];
    }
}
