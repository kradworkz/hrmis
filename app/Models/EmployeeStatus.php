<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeStatus extends Model
{
	protected $table 	= 'employee_status';
    protected $fillable = ['name'];
}