<?php

namespace hrmis\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeCOC extends Model
{
	protected $table 	= 'employee_coc';
	public $fillable 	= ['employee_id', 'beginning_hours', 'beginning_minutes', 'offset_id', 'offset_hours', 'end_hours', 'end_minutes', 'month', 'year', 'lapse_month', 'lapse_year', 'remarks', 'start', 'type', 'latest_balance'];

    public function scopeYear($query, $year)
    {
        return $query->where('year', '=', $year);
    }

    public function scopeStatus($query, $id)
    {
        if($id != "") {
            return $query->whereHas('employee', function($employee) use($id) {
                $employee->where('employee_status_id', '=', $id);
            });
        }
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function offset()
    {
    	return $this->hasOne('hrmis\Models\Offset', 'id', 'offset_id');
    }
}
