<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
	protected $table 	= 'pds_children';
	protected $fillable = ['employee_id', 'full_name', 'date_of_birth'];
	protected $dates 	= ['date_of_birth'];

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}