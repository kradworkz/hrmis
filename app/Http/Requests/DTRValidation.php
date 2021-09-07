<?php

namespace hrmis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DTRValidation extends FormRequest
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
            'date'              => 'required',
            'time_in'           => 'required',
            'time_out'          => 'required',
            'attachments'       => 'required|image',
        ];
    }

    public function attributes()
    {
        return [
            'date'              => 'Date',
            'time_in'           => 'Time In',
            'time_out'          => 'Time Out',
            'attachments'       => 'File Attachments',
        ];
    }
}