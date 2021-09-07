<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyBackground extends Model
{
	protected $table 	= 'pds_family_background';
	protected $fillable = ['employee_id', 'spouse_last_name', 'spouse_middle_name', 'spouse_first_name', 'spouse_name_extension', 'spouse_occupation',
							'business_name', 'business_address', 'business_telephone', 'father_last_name', 'father_middle_name', 'father_first_name',
							'father_name_extension', 'mother_maiden_name', 'mother_last_name', 'mother_middle_name', 'mother_first_name', 'mother_name_extension'];

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

	public function children()
	{
		return $this->hasMany('hrmis\Models\Children', 'employee_id', 'employee_id');
	}
}