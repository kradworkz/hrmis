<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class ModeOfConveyance extends Model
{
	protected $table 		= 'mode_of_conveyance';
	protected $fillable 	= ['employee_id', 'mode_of_conveyance', 'remarks'];
	
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}