<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPassenger extends Model
{
	protected $fillable = ['tagged', 'recommending_approved', 'recommending_disapproved', 'approved', 'disapproved'];

	public function travels()
	{
		return $this->hasOne('hrmis\Models\Travel', 'id', 'travel_id');
	}

	public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }
}