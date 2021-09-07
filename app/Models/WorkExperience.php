<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
	protected $table 	= 'pds_work_experience';
	protected $fillable = ['employee_id', 'start_date', 'end_date', 'position_title', 'company', 'monthly_salary', 'salary_grade', 'status_of_appointment', 'is_government'];
	protected $dates 	= ['start_date', 'end_date'];
	
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}