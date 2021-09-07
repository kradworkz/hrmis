<?php

namespace hrmis\Http\Requests;

use hrmis\Models\Vehicle;
use hrmis\Models\Employee;
use hrmis\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class ReservationValidation extends FormRequest
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
            'vehicle_id'        => 'required|sometimes',
            'start_date'        => 'required|sometimes',
            'end_date'          => 'required|sometimes',
            'time'              => 'required',
            'passengers'        => 'required',
            'destination'       => 'required',
            'purpose'           => 'required',
            'document_path.*'   => 'mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff|sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'vehicle_id'        => 'Vehicle',
            'start_date'        => 'Start Date',
            'end_date'          => 'End Date',
            'time'              => 'Time',
            'passengers'        => 'Employee',
            'destination'       => 'Destination',
            'purpose'           => 'Purpose',
            'document_path'     => 'Travel Documents',
        ];
    }
}