<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLogs extends Model
{
	protected $fillable = ['employee_id', 'ip_address', 'session_id'];

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

	public function scopeFilter($query, $employee_id, $date) 
    {
        if($employee_id) {
            $query->where('employee_id', '=', $employee_id);
        }
        elseif($date) {
            $query->whereDate('created_at', '=', $date);
        }

        return $query;
    }
}