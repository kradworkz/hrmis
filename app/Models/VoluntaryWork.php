<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class VoluntaryWork extends Model
{
	protected $table 	= 'pds_voluntary_work';
	protected $fillable = ['employee_id', 'org_info', 'start_date', 'end_date', 'number_of_hours', 'position'];
	protected $dates 	= ['start_date', 'end_date'];
	
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}