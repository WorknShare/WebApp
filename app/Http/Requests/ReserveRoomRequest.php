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
        return false;
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
          'date_start' => 'required|date_format:Y-m-d H:i:s',
          'date_end' => 'required|date_format:Y-m-d H:i:s|after:date_start',
        ];
    }
}
