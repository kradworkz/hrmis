<?php

namespace hrmis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileValidation extends FormRequest
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
            'password'                  => 'required_with:password_confirmation|confirmed|sometimes',
            'password_confirmation'     => 'required_with:password|sometimes',
            'picture'                   => 'image',
        ];
    }

    public function attributes()
    {
        return [
            'first_name'                => 'First Name',
            'middle_name'               => 'Middle Name',
            'last_name'                 => 'Last Name',
            'email'                     => 'Email Address',
            'password'                  => 'Password',
            'password_confirmation'     => 'Confirm Password',
            'picture'                   => 'Picture'
        ];
    }
}