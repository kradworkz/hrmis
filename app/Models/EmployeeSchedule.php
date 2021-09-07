<?php

namespace hrmis\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeSchedule extends Model
{
	protected $table 	= 'employee_schedule';
    protected $fillable = ['employee_id', 'day', 'time_in', 'time_out'];
}