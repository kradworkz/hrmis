<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
	protected $table 	= 'pds_personal_information';
	protected $fillable = ['last_name', 'first_name', 'middle_name', 'name_extension', 'date_of_birth', 'place_of_birth', 'gender', 'civil_status', 'height',
	 						'weight', 'blood_type', 'gsis_id', 'pagibig_id', 'philhealth_id', 'sss_id', 'tin_id', 'agency_employee_number',
	 						'citizenship', 'residential_house_info', 'residential_street', 'residential_subdivision', 'residential_barangay',
	 						'residential_city', 'residential_province', 'residential_zip_code', 'permanent_house_info', 'permanent_street',
	 						'permanent_subdivision', 'permanent_barangay', 'permanent_city', 'permanent_province', 'permanent_zip_code', 'telephone_number',
	 						'mobile_number', 'email', 'employee_id'];
	protected $dates 	= ['date_of_birth'];

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

	public function getFormattedBirthdayAttribute()
	{
		return $this->date_of_birth->format('m-d');
	}

	public function getAddressAttribute()
	{
		return $this->residential_house_info." ".$this->residential_street." ".$this->residential_barangay." ".$this->residential_subdivision.", ".$this->residential_city." ".$this->residential_province;
	}
}