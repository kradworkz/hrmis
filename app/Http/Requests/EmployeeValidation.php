<?php

namespace hrmis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeValidation extends FormRequest
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
            'first_name'                => 'required',
            'middle_name'               => 'required',
            'last_name'                 => 'required',
            'email'                     => '',
            'designation'               => 'required',
            'employee_status_id'        => 'required',
            'role_id'                   => 'required',
            'unit_id'                   => 'required',
            'contact_no'                => 'required',
            'username'                  => 'required|unique:employees,username,'.$this->segment(4),
            'password'                  => 'required|required_with:password_confirmation|confirmed|sometimes',
            'password_confirmation'     => 'required_with:password|sometimes',
            'signature'                 => 'image',
            'picture'                   => 'image',
            'is_active'                 => 'required|sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'first_name'                => 'First Name',
            'middle_name'               => 'Middle Name',
            'last_name'                 => 'Last Name',
            'email'                     => 'Email Address',
            'designation'               => 'Designation',
            'employee_status_id'        => 'Employment Status',
            'role_id'                   => 'Role',
            'unit_id'                   => 'Unit',
            'username'                  => 'Username',
            'contact_no'                => 'Contact no',
            'password'                  => 'Password',
            'password_confirmation'     => 'Confirm Password',
            'signature'                 => 'Signature',
            'picture'                   => 'Picture'
        ];
    }
}