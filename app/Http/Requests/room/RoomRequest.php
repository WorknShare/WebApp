<?php

namespace App\Http\Requests\room;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'place' => 'required|integer|min:0',
            'id_room_type' => 'required|integer|min:1',
        ];
    }
}
