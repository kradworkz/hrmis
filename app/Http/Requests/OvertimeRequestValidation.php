<?php

namespace hrmis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeRequestValidation extends FormRequest
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
            'start_date'         => 'required',
            'end_date'           => 'required',
            'purpose'            => 'required',
            'overtime_personnel' => 'required',
            'purpose'            => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'start_date'         => 'Start Date',
            'end_date'           => 'End Date',
            'purpose'            => 'Purpose',
            'overtime_personnel' => 'Employee',
        ];
    }
}