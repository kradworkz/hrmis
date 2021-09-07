<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRoles extends Model
{
	public $timestamps 	= false;
	public $fillable 	= ['employee_id', 'role_id'];
	
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

    public function role()
    {
    	return $this->hasOne('hrmis\Models\Role', 'id', 'role_id');
    }
}