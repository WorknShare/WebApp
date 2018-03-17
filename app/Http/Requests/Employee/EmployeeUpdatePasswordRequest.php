<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use App\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeUpdatePasswordRequest extends FormRequest
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
        $rules = [];
        $old = Employee::find($this->employee)->password;
        $rules['password'] ='required|string|min:6|confirmed';
        if(Auth::user()->role != 1 || Auth::user()->id_employee == $this->employee)
            $rules['oldPassword'] = array('required','string','match:'.$old);
        return $rules;
    }
}
