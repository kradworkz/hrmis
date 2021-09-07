<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
	protected $table 	= 'pds_educational_background';
    protected $fillable = ['employee_id', 'name_of_school', 'degree', 'period_from', 'period_to', 'units_earned', 'year_graduated', 'scholarship', 'type'];
    protected $dates 	= ['period_from', 'period_to'];
    public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}