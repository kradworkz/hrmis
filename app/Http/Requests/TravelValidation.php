<?php

namespace hrmis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelValidation extends FormRequest
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
            'start_date'        => 'required',
            'end_date'          => 'required',
            'destination'       => 'required',
            'mode_of_travel'    => 'required',
            'purpose'           => 'required',
            'travel_passengers' => 'required',
            'document_path.*'   => 'mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff',
            'time'              => 'required',
            'time_mode'         => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'start_date'        => 'Start Date',
            'end_date'          => 'End Date',
            'destination'       => 'Destination',
            'mode_of_travel'    => 'Mode of Travel',
            'purpose'           => 'Purpose',
            'travel_passengers' => 'Employee',
            'document_path.*'   => 'Travel Documents',
            'time'              => 'Time',
            'time_mode'         => 'Flag',
        ];
    }
}