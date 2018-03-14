<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeUpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:25',
            'surname' => 'required|string|max:25',
            'email' => 'required|string|email|unique:employees,email,' . $this->employee. ',id_employee',
            'phone' => 'nullable|string|regex:/^(\d{2}\s?){5}$/',
            'address' => 'required|string|max:255',
        ];

        if(Auth::user()->role == 1)
        {
            $rules['role'] = 'required|integer|min:0|max:3|least:' . $this->employee . ',1';
        }
        return $rules;
    }
}
