<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBalance extends Model
{
	protected $table 	= 'employee_balance';
	protected $guarded 	= [];
	
	public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }
}