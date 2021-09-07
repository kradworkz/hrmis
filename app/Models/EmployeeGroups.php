<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeGroups extends Model
{
	public $timestamps 	= false;
	public $fillable 	= ['employee_id', 'group_id'];

	public function group()
	{
		return $this->hasOne('hrmis\Models\Group', 'id', 'group_id');
	}

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id')->where('is_active', '=', 1);
	}
}
