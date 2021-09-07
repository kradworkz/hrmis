<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class OtherInformation extends Model
{
	protected $table 	= 'pds_other_information';
	protected $fillable = ['employee_id', 'skills', 'recognition', 'organization'];
	
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}