<?php

namespace hrmis\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeHealthCheck extends Model
{
    protected $guarded 	= [];
	protected $table 	= 'employee_health_check';
    protected $dates 	= ['created_at', 'updated_at', 'date'];

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }
    
    public function scopeDate($query, $date)
    {
    	return $query->whereDate('date', '=', $date);
    }
}
