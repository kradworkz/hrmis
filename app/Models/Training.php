<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
	protected $table 	= 'pds_trainings';
	protected $fillable = ['employee_id', 'title', 'start_date', 'end_date', 'number_of_hours', 'type', 'conducted_by'];
	protected $dates 	= ['start_date', 'end_date'];
	
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}