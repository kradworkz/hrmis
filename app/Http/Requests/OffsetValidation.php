<?php

namespace hrmis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffsetValidation extends FormRequest
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
            'date'      => 'required',
            'time'      => 'required',
            'remarks'   => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date'      => 'Date',
            'time'      => 'Time',
            'remarks'   => 'Remarks',
        ];
    }
}